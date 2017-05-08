<?php

namespace Medlib\Traits;

use Illuminate\Support\Facades\Input;
use Greggilbert\Recaptcha\Facades\Recaptcha;

trait CaptchaTrait
{
    public function captchaCheck()
    {
        $response = Input::get('g-recaptcha-response');
        $remoteIP = request()->ip();
        $secret   = env('RE_CAP_SECRET');
        $recaptcha = new ReCaptcha($secret);

        $resp = $recaptcha->verify($response, $remoteIP);
        if ($resp->isSuccess()) {
            return 1;
        } else {
            return 0;
        }
    }
}
