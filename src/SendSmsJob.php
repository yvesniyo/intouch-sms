<?php

namespace Yvesniyo\IntouchSms;

use App\Services\Sms;
use GuzzleHttp\Client;

class SendSmsJob
{
    public $sms;

    /**
     * Execute the job.
     *
     * @return void
     */
    public static function now(SmsAbstract $sms)
    {

        $json = null;
        // check if we are in laravel app
        try {
            $app = app()->version();
            //we are in laravel app
            $datas = [
                "sender" => $sms->getSender(),
                "message" => $sms->getMessage(),
                "recipients" => $sms->getRecipients(),
                "dlrurl" => $sms->getCallBackUrl(),
            ];
            $response = \Illuminate\Support\Facades\Http::withBasicAuth(
                $sms->getUsername(),
                $sms->getPassword()
            )
                ->retry(10, 1000)
                ->asForm()
                ->post($sms->getApiUrl(), $datas);
            if ($response->ok()) {
                $json = $response->json();
            }
        } catch (\Throwable $th) {
            //we are not in laravel app
            $client = new Client();
            $res = $client->request('POST', $sms->getApiUrlQuery(), [
                'auth' => [$sms->getUsername(), $sms->getPassword(), "digest"],
            ]);
            $response = $res;
            if ($response->getStatusCode()) {
                $json = json_decode($response->getBody(), true);
            }
        }
        if ($json) {
            return self::afterSuccess($json, $sms);
        } else {
            throw new \Exception("Unknown error occured while trying to send sms", 1);
        }
        return true;
    }


    public static function afterSuccess($json, Sms $sms)
    {

        $success = $json['success'];
        if ($success) {
            $details = $json['details'];
            foreach ($details as $detail) {
                $json = $detail;
                $status = $json["status"];
                $cost = $json["cost"];
                $messageid = $json["messageid"];
                $message = $json["message"];
                if ($sms->getSender()) {
                    $extra = ([
                        "status" => $status,
                        "cost" => $cost,
                        "messageid" => $messageid,
                        "message" =>  $message,
                        "extra" => $sms->getExtraJson(),
                        "call_back_url" => $sms->getCallBackUrl(),
                        "recipients" => $json["receipient"],
                        "sender" => $sms->getSender(),
                        "username" => $sms->getUsername(),
                        "user_id" => $sms->getSenderId(),
                        'time' => time(),
                    ]);
                    return $extra;
                }
            }
        }
        $summary = $json['summary'] ?? false;
        if ($success && ($summary)) {
        }
    }
}
