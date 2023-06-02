<?php

namespace App\Symptom\Utils\Clients\chatGPT;


use OpenAI\Client as OpenAI;

interface ClientInterface
{
    public function sendRequest(string $prompt): mixed;
}
