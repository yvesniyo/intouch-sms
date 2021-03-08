# yvesniyo/intouch-sms

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][packagist]
[![Software License][badge-license]][license]
[![PHP Version][badge-php]][php]
[![Build Status][badge-build]][build]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]

[badge-source]: http://img.shields.io/badge/source-yvesniyo/intouch-sms-blue.svg?style=flat-square
[badge-release]: https://img.shields.io/packagist/v/yvesniyo/intouch-sms.svg?style=flat-square&label=release
[badge-license]: https://img.shields.io/packagist/l/yvesniyo/intouch-sms.svg?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/yvesniyo/intouch-sms.svg?style=flat-square
[badge-build]: https://img.shields.io/travis/yvesniyo/intouch-sms/master.svg?style=flat-square
[badge-coverage]: https://img.shields.io/coveralls/github/yvesniyo/intouch-sms/master.svg?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/yvesniyo/intouch-sms.svg?style=flat-square&colorB=mediumvioletred
[source]: https://github.com/yvesniyo/intouch-sms
[packagist]: https://packagist.org/packages/yvesniyo/intouch-sms
[license]: https://github.com/yvesniyo/intouch-sms/blob/master/LICENSE
[php]: https://php.net
[build]: https://travis-ci.org/yvesniyo/intouch-sms
[coverage]: https://coveralls.io/r/yvesniyo/intouch-sms?branch=master
[downloads]: https://packagist.org/packages/yvesniyo/intouch-sms

This is a php library to help developers include sms service, with IntouchSms gateway from RWANDA

## Installation

Install this package as a dependency using [Composer](https://getcomposer.org).

```bash
composer require yvesniyo/intouch-sms
```

## Usage

This is the documantion

```php
use Yvesniyo\IntouchSms\SmsSimple;

/** @var \Yvesniyo\IntouchSms\SmsSimple */
$sms = new SmsSimple();
$sms->recipients(["250780588642","0720710379"])
    ->message("Hello world")
    ->sender("intouchSenderId")
    ->username("intouchUsername")
    ->password("intouchPassword")
    ->apiUrl("www.intouchsms.co.rw/api/sendsms/.json")
    ->callBackUrl("");
print_r($sms->send());

```

That code works well, however it does call some static parameters such as senderId,Username,Password,ApiUrl and CallbackUrl. we can solve this by creating another class Called Sms which extends SmsAbstract

```php


class Sms extends SmsAbstract
{
    public function __construct()
    {
        parent::__construct();

        //
    }

    public function configSender(): string
    {
        return "intouchSenderId";
    }

    public function configUsername(): string
    {
        return "intouchUsername";
    }

    public function configPassword(): string
    {
        return "intouchPassword";
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

```

After creating this class you can now use simple codes like

```php

$sms = new Sms();
// first parameter is recipients and second one is message
$sms->requiredData(["250780588642","0720710379"], "wassup");
print_r($sms->send());

```

NB: For some people who are not using composer remember to add:

```php
include_once("../vendor/autoload.php");
```

## Contributing

Contributions are welcome! Before contributing to this project, familiarize
yourself with [CONTRIBUTING.md](CONTRIBUTING.md).

To develop this project, you will need [PHP](https://www.php.net) 7.4 or greater,
[Composer](https://getcomposer.org),

After cloning this repository locally, execute the following commands:

```bash
cd /path/to/repository
composer install
```

Now, you are ready to develop!

## Copyright and License

The yvesniyo/intouch-sms library is free and unencumbered software released into the
public domain. Please see [UNLICENSE](UNLICENSE) for more information.
