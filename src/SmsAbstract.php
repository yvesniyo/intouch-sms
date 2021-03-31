<?php


namespace Yvesniyo\IntouchSms;

use Yvesniyo\IntouchSms\SendSmsJob;

abstract class SmsAbstract
{

    private $sender, $username, $message, $password, $recipients, $callBackUrl;
    private String $extra = "[]";
    private $senderId;
    private String $apiUrl;

    /**
     * Array must contain sender,username,password all as Strings
     */


    abstract function configSender(): string;
    abstract function configUsername(): string;
    abstract function configPassword(): string;
    abstract function configApiUrl(): string;
    abstract function configCallBackUrl(): string;

    public function __construct()
    {
        $this->configure();
    }

    protected function configure(): void
    {
        $this->sender = $this->configSender();
        $this->username = $this->configUsername();
        $this->password = $this->configPassword();
        $this->apiUrl = $this->configApiUrl();
        $this->callBackUrl = $this->configCallBackUrl() ?? "https://" . strtolower($this->sender) . ".requestcatcher.com/sms";
    }


    public function extra(array $data): SmsAbstract
    {
        $this->extra = json_encode($data);
        return $this;
    }

    public function addExtra(array $data): SmsAbstract
    {
        $this->extra = json_encode(array_merge($this->getExtra(), $data));
        return $this;
    }

    public function senderId(int $senderId): SmsAbstract
    {
        $this->senderId = $senderId;
        return $this;
    }

    public function getExtra()
    {
        return json_decode($this->extra, true);
    }

    public function getExtraJson()
    {
        return $this->extra;
    }


    public function sender($sender): SmsAbstract
    {
        $this->sender = $sender;
        return $this;
    }

    public function username($username): SmsAbstract
    {
        $this->username = $username;
        return $this;
    }

    public function message($message): SmsAbstract
    {
        $this->message = $message;
        return $this;
    }


    public function password($password): SmsAbstract
    {
        $this->password = $password;
        return $this;
    }

    public function recipients($recipients): SmsAbstract
    {
        if (is_array($recipients)) {
            $this->recipients = implode(",", $recipients);
        } else {
            $this->recipients = $recipients;
        }
        return $this;
    }

    public function addRecipient($recipient): SmsAbstract
    {
        $recipients = $this->recipients;
        if ($recipients == null || $recipients == "") {
            $recipients = "";
            $recipients .= $recipient;
        } else {
            $recipients .= "," . $recipient;
        }
        $this->recipients = $recipients;
        return $this;
    }



    public function getSender()
    {
        return $this->sender;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRecipients()
    {
        return $this->recipients;
    }

    public function getCallBackUrl()
    {
        return $this->callBackUrl;
    }

    public function callBackUrl(string $callBackUrl)
    {
        $this->callBackUrl = $callBackUrl;
    }


    public function toArray()
    {
        return [
            "sender" => $this->getSender(),
            "extra" => $this->getExtra(),
            "message" => $this->getMessage(),
            "username" => $this->getUsername(),
            "password" => $this->getPassword(),
            "callBackUrl" => $this->getCallBackUrl(),
            "recipients" => $this->getRecipients(),
            "senderId" => $this->getSenderId(),
            "apiUrl" => $this->getApiUrl(),
        ];
    }


    public function __toString()
    {
        return json_encode($this->toArray());
    }


    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }


    public function getSenderId()
    {
        return $this->senderId;
    }


    public function requiredData($recipients, String $message, String $senderId = null)
    {
        $this->recipients($recipients);
        $this->message($message);
        if ($senderId) {
            $this->senderId($senderId);
        }
    }



    public function send()
    {
        return SendSmsJob::now($this);
    }

    /**
     * Get the value of apiUrl
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Get the value of apiUrlQuery
     */
    public function getApiUrlQuery()
    {
        $datas = [
            "username" => $this->getUsername(),
            "password" => $this->getPassword(),
            "sender" => $this->getSender(),
            "message" => $this->getMessage(),
            "recipients" => $this->getRecipients(),
            "dlrurl" => $this->getCallBackUrl(),
        ];
        $datas = http_build_query($datas);
        return $this->apiUrl . "?" . $datas;
    }

    /**
     * Set the value of apiUrl
     *
     * @return  self
     */
    public function apiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }
}
