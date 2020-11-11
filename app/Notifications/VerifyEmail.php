<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;

/**
 * Class VerifyEmail
 *
 * Override VerifyEmail from Laravel in order to implement our queue
 */
class VerifyEmail extends BaseVerifyEmail implements ShouldQueue
{
    use Queueable;
}
