<?php
namespace Rinco;

class ApiManager
{
    protected $jobId;
    protected $token;

    function __construct(string $jobId, string $token) 
    {
        $this->jobId = $jobId;
        $this->token = $token;
    }
    public function getData(): array
    {
        $ch = curl_init();

        $baseURL = getenv("RINCO_API_MANAGER_URL") ?? "https://rinco.io/api/";
        curl_setopt($ch, CURLOPT_URL, $baseURL . $this->jobId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $this->token,
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);
    }
}