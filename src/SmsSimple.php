<?php

namespace  Yvesniyo\IntouchSms;

class SmsSimple extends SmsAbstract
{
    public function __construct()
    {
        parent::__construct();

        //
    }

    public function configSender(): string
    {
        return "";
    }

    public function configUsername(): string
    {
        return "";
    }

    public function configPassword(): string
    {
        return "";
    }

    public function configApiUrl(): string
    {
        return "";
    }

    public function configCallBackUrl(): string
    {
        return "";
    }
}
