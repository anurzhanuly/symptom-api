<?php
namespace App\Symptom\Utils\Clients\Sms;

use Mobizon\MobizonApi;

class Sms implements SmsInterface
{
    protected MobizonApi $client;

    public function __construct()
    {
        $this->client = new MobizonApi(config('mobizon.key'), config('mobizon.url'));
    }

    public function sendOne(string $phone, string $message): bool
    {
        try {
            $this->client->call('message',
                'sendSMSMessage',
                [
                    'recipient' => $phone,
                    'text'      => $message,
                ]
            );

            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }
}
