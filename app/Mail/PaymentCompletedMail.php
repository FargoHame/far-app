<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Payment;

class PaymentCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $payment_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment_id = $payment->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $payment = Payment::find($this->payment_id);

        return $this->from(config('mail.from.address'),config('mail.from.name'))
            ->subject('Payment completed')
            ->view('mail.payment-completed-html')
            ->text('mail.payment-completed-text')
            ->with([
                'preceptor' => $payment->application->rotation->preceptor,
                'student' => $payment->application->student,
                'application' => $payment->application
                ]);
    }
}
