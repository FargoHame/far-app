<?php

namespace App\Http\Controllers;

use App\Models\GigwagePayment;
use App\Models\Rotation;
use App\Models\User;
use Database\Seeders\Rotations;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Application;
use App\Models\File;
use App\Models\Message;
use App\Models\Payment;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Mail\ApplicationStatusChangedMail;
use App\Mail\PaymentCompletedMail;
use App\Models\Fee;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class ApplicationsController extends Controller
{


    public function viewApplications() {
        $applications = Application::where(['student_user_id' => Auth::user()->id])->orderBy('created_at', 'DESC')->paginate(config("rotation.pagination_size"))->withQueryString();
        return view('student.applications', ['applications' => $applications]);
    }

    public function viewApplication(Application $application) {
        // get price
        $price=($application->rotation->price_per_week_in_cents * $application->rotation_slots->count())/100;
        // get fee base in the price
        $feePercentage= Fee::where('min', '<=', $price)->where('max', '>=', $price)->get()->first();
        // calculate the total fee
        $fee= is_null($feePercentage) ? 0 :$price * ($feePercentage->fee /100);

        $messages = Message::where(['application_id' => $application->id])->orderBy('created_at','ASC')->get();
        return view('student.application',['application' => $application,'rotation' => $application->rotation,'messages' => $messages,'fee'=>$fee, 'price'=>$price]);
    }

    public function withdraw(Request $request) {
        $application = Application::find($request->application_id);
        $application->status = "withdrawn";
        $application->save();

        return redirect()->route('student-applications');
    }

    public function pay(Application $application) {

        $totalPay = $this->calculateTotalPay($application) / $application->rotation_slots->count();
        $payment = new Payment();
        $payment->application_id = $application->id;
        $payment->user_id = Auth::user()->id;
        $payment->hash = Str::random(60);
        $payment->save();
        try {
            return Auth::user()->checkoutCharge(
                $totalPay,
                $application->rotation->preceptor_name,
                $application->rotation_slots->count(),
                [
                    'success_url' => route('student-application-payment-success', ['payment' => $payment,'hash' => $payment->hash]),
                    'cancel_url' => route('student-application-payment-failed', ['payment' => $payment]),
                ]
            );

        } catch (\exception $e) {
            return redirect()->route('student-application-payment-failed', ['payment' => $payment]);
        }
    }

    public function calculateTotalPay($application, $affliate=true) {

        // convet from cent
        $price=($application->rotation->price_per_week_in_cents * $application->rotation_slots->count())/100;
        $feePercentage= Fee::where('min', '<=', $price)->where('max', '>=', $price)->get()->first();
        // calculate the total fee
        $fee= $price * (is_null($feePercentage) ? 0 : $feePercentage->fee / 100);
        // convert to cent
        if ($affliate)
         $total=($fee+$price) *100;
        else
         $total=$price*100;

        return $total;

    }


    public function paymentSuccess(Request $request, Payment $payment) {
        if ($request->hash==$payment->hash) {
            try {

                $payment->status = 'success';
                $payment->save();
                $payment->application->status = 'paid';
                $payment->application->save();

                Mail::to([$payment->application->rotation->preceptor->email])->send(new PaymentCompletedMail($payment));

                // $this->rewardEstudent($payment);
                // $this->rewardPreceptor($payment);
                // $this->sendPaymentPreceptor($payment);
                return redirect()->route('student-application-view',['application' => $payment->application,'success' => 'true']);


            }catch (\exception $e){
                return redirect()->route('student-application-payment-failed',['payment' => $payment]);
            }
        }

        return redirect()->route('student-application-view',['application' => $payment->application,'success' => 'failed']);
    }

    public function rewardEstudent($payment){
        // $user = Auth::user();
        // $payments = Payment::where(['user_id' => Auth::user()->id])->get();
        // $Referrer = User::where(['code_prefinary' => $user->get_referral_code()])->get()->first();
        // $this->send($Referrer,$user,$payments,$payment);

       $user = User::find($payment->user_id);
       $payments = Payment::where(['user_id' => $user->id])->get();
       $Referrer = User::where(['code_prefinary' => $user->get_referral_code()])->get()->first();
       $this->send($Referrer,$user,$payments,$payment);
    }

    public function rewardPreceptor($payment){

        $rotation = Rotation::where(['id' => $payment->application->rotation_id])->get()->first();
        $user = User::find($rotation->preceptor_user_id);
        $Referrer = User::where(['code_prefinary' => $user->get_referral_code()])->get()->first();
        $payments = Application::where(['rotation_id' => $rotation->id])->get();
        $this->send($Referrer,$user,$payments,$payment);
    }

    public function sendPaymentPreceptor($payment){

        $rotation = Rotation::where(['id' => $payment->application->rotation_id])->get()->first();
        $amountToPay=$this->calculateTotalPay($payment->application,false)/100;
        $user = User::find($rotation->preceptor_user_id);
        if (!$user || !$user->gigwage_id)
        {
            $this->saveGigwagePaymentDefault($amountToPay,$user,$payment);
            return false;
        }

        $this->sendPayment($payment,$user,$amountToPay,false);

    }

    public function saveGigwagePaymentDefault($amountToPay,$user,$payment){

        $GigwagePayment = new GigwagePayment();
        $GigwagePayment->gigwage_id = 0;//is who receives the payment
        $GigwagePayment->description ='payment attempt  by  $'.$amountToPay.'  userid #'.$user->id.' - paymentid #'.$payment->id;
        $GigwagePayment->amount  = $amountToPay;
        $GigwagePayment->user_id =  Auth::user()->id; // is who makes the payment
        $GigwagePayment->payload = '';
        $GigwagePayment->response ='No user found in Gigwage';
        $GigwagePayment->save();

    }


    public function send($Referrer,$user,$payments,$payment){
        if (!$user || !$user->gigwage_id)
            return false;
        $amountToPay=$this->payoutRules($user,$Referrer);

        if ($this->validateReward($user,$payments,$amountToPay))
            $this->sendPayment($payment,$Referrer,$amountToPay);
    }

    public function payoutRules($user,$Referrer){
        if ($Referrer !== null) {
            if ($Referrer->role=='student')
                switch ($user->role) {
                    case 'student':
                        return 25;
                    case 'preceptor':
                        return 50;
                }
            if ($Referrer->role=='preceptor')
                switch ($user->role) {
                    case 'student':
                        return 25;
                    case 'preceptor':
                        return 75;
                }
        } else {
            return 0;
        }
    }

    public function validateReward($user,$payments,$amountToPay){

        $paymentsCount = $payments->count();
        $referral_code = $user->referral_code;

        if(($paymentsCount>1) || $referral_code==null)
            return false;

        if($amountToPay==0)
            return false;

        return true;
    }


    public function sendPayment($payment,$Referrer,$amountToPay, $affliate=true){

        $date= \Carbon\Carbon::parse(now())->toFormattedDateString();
        $total=$this->calculateTotalPay($payment->application)/100;

        if($affliate)
           $reason = 'Your referal purchased item '.$payment->application->id.' for $'.$total.' on '.$date;
        else
           $reason = 'payment per purchase item '.$payment->application->rotation_id.' for $'.$amountToPay.' on '.$date;

        $nonce = $Referrer->gigwage_id.'-'.$Referrer->id.'-'.$payment->application->id.'-'.$amountToPay;
        $payload = "{\"payment\":{\"contractor_id\":$Referrer->gigwage_id,\"line_items\":[{\"amount\":$amountToPay,\"reason\":\"$reason\"}],\"nonce\":\"$nonce\"}}";
        $GigwagePayment = new GigwagePayment();
        $GigwagePayment->gigwage_id = $Referrer->gigwage_id; // is who receives the payment
        $GigwagePayment->description =$reason;
        $GigwagePayment->amount =$amountToPay;
        $GigwagePayment->user_id = Auth::user()->id; // is who makes the payment
        $GigwagePayment->payload = $payload;

        $method = "POST";
        $endpoint = "/api/v1/payments";
        $secret = env('GIGWAGE_APP_SECRET');
        $timestamp= time();
        $timestamp= $timestamp*1000;
        $data = $timestamp . $method . $endpoint . $payload;
        $signature = hash_hmac('sha256', $data, $secret);
        $URL=env('GIGWAGE_APP_URL');
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "$URL.$endpoint",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "content-type: application/json",
                "X-Gw-Api-Key: ".env('GIGWAGE_APP_KEY'),
                "X-Gw-Timestamp: ".$timestamp,
                "X-Gw-Signature: ".$signature
            ],
        ]);

        $response=curl_exec($curl);
        $err = curl_error($curl);

        if (!curl_errno($curl)) {
            switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
                case 201:  # OK
                    $GigwagePayment->status = 'success';
                default:
                    $GigwagePayment->response =$response;
            }
        }
        if ($err) {
            $GigwagePayment->response =$err;
        }

        curl_close($curl);
        $GigwagePayment->save();
    }


    public function paymentFailed(Request $request, Payment $payment) {
        $payment->status = 'failed';
        $payment->save();

        return redirect()->route('student-application-view',['application' => $payment->application,'success' => 'failed']);
    }

    public function adminViewApplication(Application $application) {
        $messages = Message::where(['application_id' => $application->id])->orderBy('created_at','DESC')->get();
        return view('admin.application-view',['application' => $application,'rotation' => $application->rotation,'messages' => $messages]);
    }

    public function preceptorViewApplication(Application $application) {
        $messages = Message::where(['application_id' => $application->id])->orderBy('created_at','ASC')->get();
        return view('preceptor.application-view',['application' => $application,'rotation' => $application->rotation,'messages' => $messages]);
    }

    public function preceptorAcceptApplication(Application $application) {
        $application->status = 'accepted';
        $application->save();
        try {
            Mail::to([$application->student->email])->send(new ApplicationStatusChangedMail($application));
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->route('preceptor-application-view',['application' => $application, 'status'=>'accepted']);
    }

    public function preceptorRejectApplication(Application $application) {
        $application->status = 'rejected';
        $application->save();

        Mail::to([$application->student->email])->send(new ApplicationStatusChangedMail($application));
        return redirect()->route('preceptor-application-view',['application' => $application, 'status'=>'rejected']);
    }

    public function downloadFile(File $file) {
        return Storage::download($file->path, $file->filename);
    }
}
