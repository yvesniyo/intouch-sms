<?php

namespace  Yvesniyo\IntouchSms;

class Sms extends SmsAbstract
{
    public function __construct()
    {
        parent::__construct();
    }

    public function configSender(): string
    {
        return "Banguka";
    }

    public function configUsername(): string
    {
        return "yvesniyo";
    }

    public function configPassword(): string
    {
        return "amafaranga";
    }

    public function configApiUrl(): string
    {
        return "www.intouchsms.co.rw/api/sendsms/.json";
    }

    public function configCallBackUrl(): string
    {
        return "";
    }
}
