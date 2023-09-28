<?php
namespace App\Symptom\Utils\Clients\Sms;

interface SmsInterface
{
    public function sendOne(string $phone, string $message): bool;
}
