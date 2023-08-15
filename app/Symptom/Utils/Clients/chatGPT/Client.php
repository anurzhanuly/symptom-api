<?php

namespace App\Symptom\Utils\Clients\chatGPT;

use Illuminate\Support\Facades\Log;

class Client implements ClientInterface
{
    private \OpenAI\Client $client;

    public function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        $this->client = \OpenAI::client(config('openai.api_key'));
    }

    public function sendRequest(string $prompt): mixed
    {
        try {
            Log::log(
                'info',
                'chatGPT request',
                ['model' => config('openai.model'), 'key' => config('openai.api_key')]
            );

            return $this->client->completions()->create([
                'model' => config('openai.model'),
                'prompt' => $prompt,
                'temperature' => 0.1,
                'max_tokens' => 1000,
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
