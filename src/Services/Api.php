<?php


namespace App\Services;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class Api
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    public function getCompanyBySirene($sirene){
        $response = $this->client->request(
            'GET',
            $_ENV['API'].''.$sirene
        );
        try {
            $content = $response->getContent();
        }catch (\Exception $e){
            return [
                "id" => null,
                "denomination" => null,
                "error" => true,
                "message" => $e->getMessage()
            ];
        }

       return json_decode($content, true);
    }
}