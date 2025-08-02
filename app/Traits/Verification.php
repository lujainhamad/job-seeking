<?php

namespace App\Traits;

use App\Jobs\SendNotification;
use App\Mail\OtpMail;
use App\Mail\ResetPasswordMail;
use App\Mail\VerificationMail;
use App\Models\EmailType;
use App\Services\Notifications\EmailNotificationService;
use App\Services\Notifications\SMSNotificationService;
use Carbon\Carbon;

trait Verification
{
    public function isEmailVerified()
    {
        return $this->verified_at != null;
    }
    public function isPhoneVerified()
    {
        return $this->phone_verified_at != null;
    }

    public function setAsVerified()
    {
        $this->verified_at = Carbon::now();
        $this->save();
        return true;
    }

    public function setAsPhoneVerified()
    {
        $this->phone_verified_at = Carbon::now();
        $this->save();
        return true;
    }

    public function generateVerificationCode($type)
    {
        

        $code = "000000";
        $lastVerificationCode = $this->verficationCodes()->where('type', $type)
            ->where('verified_at', null)
            ->latest()
            ->first();
        if ($lastVerificationCode) {
            $lastVerificationCode->update(['code' => $code]);
        }else {
            $this->verficationCodes()->create([
                'code' => $code,
                'type' => $type
            ]);
        }

        $lastVerificationCodePhone = $this->verficationCodes()->where('type', $type)
            ->where('phone_verified_at', null)
            ->latest()
            ->first();
        if ($lastVerificationCodePhone) {
            $lastVerificationCodePhone->update(['code' => $code]);
        } else {
            $this->verficationCodes()->create([
                'code' => $code,
                'type' => $type
            ]);
        }
        return $code;
    }

    public function sendVerificationCodeByPhone($phone, $code)
    {
        
        $smsService = new SMSNotificationService($phone, __('custom.auth.reset_password_code_message', ['code' => $code]));
        SendNotification::dispatch($smsService);
        return true;
    }

    public function sendVerificationCodeByEmail($user, $code)
    {
        $data = [
            'code' => $code,
            'name' => $user->name
        ];
        $mail = new OtpMail($data, __('custom.auth.verfication_subject'), $user->name, $code);
        $emailService = new EmailNotificationService(to: $user->email, mail: $mail);
        SendNotification::dispatch($emailService);

        return true;
    }

    public function sendResetPasswordCodeByPhone($phone, $code)
    {
        $smsService = new SMSNotificationService($phone, __('custom.auth.reset_password_code_message', ['code' => $code]));
        SendNotification::dispatch($smsService);
        return true;
    }

    public function sendResetPasswordCodeByEmail($user, $code)
    {
        $data = [
            'code' => $code,
            'name' => $user->name
        ];
        $mail = new OtpMail($data, __('custom.auth.verfication_subject'), $user->name, $code);
        $emailService = new EmailNotificationService(to: $user->email, mail: $mail);
        SendNotification::dispatch($emailService);

        return true;
    }

    public function checkVerificationCode($code, $type)
    {
        if ($type == 'verification_email') {
            $verification_code = $this->verficationCodes()
            ->where('code', $code)
            ->where('type', $type)
            ->where('created_at', '>=', Carbon::now()->subMinutes(15))
            
            ->latest()
            ->first();
            if ($verification_code) {
                $verification_code->verified_at = Carbon::now();
                $verification_code->save();
                return true;
            } else {
                return false;
            }
        }else {
            $verification_code_phone = $this->verficationCodes()
            ->where('code', $code)
            ->where('type', $type)
            ->where('created_at', '>=', Carbon::now()->subMinutes(15))
            ->latest()
            ->first();

        if ($verification_code_phone) {
            $verification_code_phone->phone_verified_at = Carbon::now();
            $verification_code_phone->save();
            return true;
        } else {
            return false;
        }
        }
    }
}
