<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HuggingFaceService
{
    protected $client;
    protected $apiKey;
    protected $model;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api-inference.huggingface.co/models/',
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.huggingface.api_key'),
                'Content-Type' => 'application/json',
            ],
        ]);
        $this->model = config('services.huggingface.model', 'gpt2');
    }

    public function generateResponse($input)
    {

        $response = $this->client->post($this->model, [
            'json' => [
                'inputs' => $input,
                'parameters' => [
                    'max_length' => 100,
                    'num_return_sequences' => 1,
                ],
            ],
        ]);
        dd($response->getBody());
        $result = json_decode($response->getBody(), true);
        return $result[0]['generated_text'] ?? 'Sorry, I couldn\'t generate a response.';
    }
}
