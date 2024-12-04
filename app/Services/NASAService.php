<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NASAService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.nasa.api_key');
        $this->baseUrl = config('services.nasa.api_url');
    }

    public function getData(string $endpoint, array $params = [])
    {
        $params['api_key'] = $this->apiKey;

        $response = Http::get("{$this->baseUrl}/{$endpoint}", $params);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Error fetching data from NASA API: ' . $response->body());
    }
}
