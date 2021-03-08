<?php

namespace Yvesniyo\IntouchSms;

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

        $client = new Client();
        $res = $client->request('POST', $sms->getApiUrlQuery(), [
            'auth' => [$sms->getUsername(), $sms->getPassword(), "digest"],
        ]);


        $response = $res;
        if ($response->getStatusCode()) {
            $json = json_decode($response->getBody(), true);
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
                            'time' => mktime(),
                        ]);
                        return $extra;
                    }
                }
            }
            $summary = $json['summary'] ?? false;
            if ($success && ($summary)) {
            }
        }

        return false;
    }
}
