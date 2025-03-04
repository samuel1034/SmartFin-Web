<?php

namespace App\Services;

use Illuminate\Support\Facades;
use Symfony\Component\Console\Question\Question;

class DeepSeekService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.deepseek.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.deepseek.key');
    }

    public function askFinanceQuestion($question)
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer" . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("$this->baseUrl/chat/completions", [
            'model' => "deepseek-1.3",
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $question,
                ],
            ],
            'temperature' => 0.7,
            'max-tokens' => 500
        ]);
        return $response->json()['choices'][0]['message']['content'] ?? 'Sorry, I do not know the answer to that question';
    }
}


