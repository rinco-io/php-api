<?php

namespace Rinco;

class Rinco
{

    protected $baseURL;
    protected $jobId;

    function __construct(string $baseURL, string $jobId) 
    {
        $this->baseURL = $baseURL;
        $this->jobId = $jobId;
    }
    public function getData(string $token): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->baseURL . $this->jobId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $token,
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);
    }
}