<?php

namespace App\Services;

interface SlackNotificationServiceInterface
{
    public function send($message);
}
