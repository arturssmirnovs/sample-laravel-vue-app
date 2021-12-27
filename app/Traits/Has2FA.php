<?php

namespace App\Traits;

use App\Models\UserCode;
use Twilio\Rest\Client;

trait Has2FA
{
    public function need2FA()
    {
        return $this->enabled_2fa;
    }

    public function check2FA($code)
    {
        if ($code == $this->code->code) {
            return true;
        }

        return false;
    }

    public function send2FACode()
    {
        $code = rand(1000, 9999);

        UserCode::updateOrCreate(['user_id' => $this->id], ['code' => $code]);
//
//        $receiverNumber = $this->phone;
//
//        $message = "2FA login code is ". $code;
//
//        try {
//            $client = new Client(getenv("TWILIO_SID"), getenv("TWILIO_TOKEN"));
//            $client->messages->create($receiverNumber, ['from' => getenv("TWILIO_FROM"), 'body' => $message]);
//        } catch (\Exception $e) {
//            info("Error: ". $e->getMessage());
//        }
    }
}
