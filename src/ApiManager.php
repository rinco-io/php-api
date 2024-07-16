<?php
namespace Rinco;

use Exception;

class ApiManager
{
    protected $data;

    function __construct(string $jobId, string $token) 
    {
        $ch = curl_init();

        $baseURL = getenv("RINCO_API_MANAGER_URL") ?? "https://rinco.io/api/";
        curl_setopt($ch, CURLOPT_URL, $baseURL . $jobId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $token,
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            $error_code = curl_errno($ch);
            $error_message = curl_error($ch);
            throw new Exception("cURL Error ($error_code): $error_message");
        }

        curl_close($ch);

        $this->data = json_decode($response);
    }
    public function get(string $path): string|object
    {
        $keys = explode('->', $path);
        $value = $this->data;

        foreach ($keys as $key) {
            if (is_object($value) && property_exists($value, $key)) {
                $value = $value->$key;
            } else {
                throw new Exception("Key not found: $key");
            }
        }

        return $value;
    }
    public function getAll(): object
    {
        return $this->data;
    }
}