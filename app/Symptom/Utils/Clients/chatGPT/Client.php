<?php

namespace App\Symptom\Utils\Clients\chatGPT;

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
            return $this->client->completions()->create([
                'model' => config('openai.model'),
                'prompt' => $prompt,
                'temperature' => 0.1,
                'max_tokens' => 500,
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
