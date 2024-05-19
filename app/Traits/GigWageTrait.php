<?php

namespace App\Traits;

use App\Models\User;

trait GigWageTrait
{
    public function registreContractor($role, $email, $first_name, $last_name, $user_id, &$validator = null)
    {

        $payload = "{\"contractor\":{\"email\":\"$email\",\"first_name\":\"$first_name\",\"last_name\":\"$last_name\",\"external_id\":\"$user_id\",\"send_invite\":false}}";

        $timestamp = time();
        $timestamp = $timestamp * 1000;
        $method = "POST";
        $endpoint = "/api/v1/contractors";
        $secret = env('GIGWAGE_APP_SECRET');
        $data = $timestamp . $method . $endpoint . $payload;
        $signature = hash_hmac('sha256', $data, $secret);
        $URL = env('GIGWAGE_APP_URL');
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
                "X-Gw-Api-Key: " . env('GIGWAGE_APP_KEY'),
                "X-Gw-Timestamp: " . $timestamp,
                "X-Gw-Signature: " . $signature
            ],
        ]);

        $responses = curl_exec($curl);
        $err = curl_error($curl);

        if (!curl_errno($curl)) {
            curl_close($curl);
            switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
                case 201:  # OK
                    $responses = json_decode($responses);
                    User::where('id', $user_id)->update(array('gigwage_id' => $responses->contractor->id));
                    return true;
                default:
                    if ($role == 'preceptor') {
                        return false;
                        $validator->getMessageBag()->add('error', $responses);
                    }
                    return false;
            }
        }
        if ($err) {
            curl_close($curl);
            $validator->getMessageBag()->add('Error', $err);
            return false;
        }
    }
    public function inviteContractor($id)
    {
        $timestamp = time();
        $timestamp = $timestamp * 1000;
        $method = "POST";
        $endpoint = "/api/v1/contractors/" . $id . "/invite";
        $secret = env('GIGWAGE_APP_SECRET');
        $data = $timestamp . $method . $endpoint . $id;
        $signature = hash_hmac('sha256', $data, $secret);
        $URL = env('GIGWAGE_APP_URL');
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "$URL.$endpoint",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $id,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "content-type: application/json",
                "X-Gw-Api-Key: " . env('GIGWAGE_APP_KEY'),
                "X-Gw-Timestamp: " . $timestamp,
                "X-Gw-Signature: " . $signature
            ],
        ]);
        $responses = curl_exec($curl);
        $err = curl_error($curl);
        if (!curl_errno($curl)) {
            curl_close($curl);
            switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
                case 201:  # OK
                    return true;
                case 400:
                    return false;
                case 404:
                    return false;
                default:
                    return false;
            }
        }
        if ($err) {
            curl_close($curl);
            return false;
        }
    }
}
