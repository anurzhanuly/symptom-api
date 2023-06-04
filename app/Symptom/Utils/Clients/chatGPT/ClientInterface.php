<?php

namespace App\Symptom\Utils\Clients\chatGPT;


interface ClientInterface
{
    public function sendRequest(string $prompt): mixed;
}
