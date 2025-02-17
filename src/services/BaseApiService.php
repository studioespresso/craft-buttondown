<?php

namespace studioespresso\buttondown\services;

use craft\base\Component;
use craft\helpers\App;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use studioespresso\buttondown\Buttondown;

class BaseApiService extends Component
{
    private string|null $apiKey = null;

    private string $baseUrl = 'https://api.buttondown.email/v1/';

    public function init(): void
    {
        $this->apiKey = App::parseEnv(Buttondown::getInstance()->getSettings()->apiKey);
        parent::init();
    }


    public function makeApiCall(string $path, array $data = [])
    {
        try {
            $client = new Client(['base_uri' => $this->baseUrl]);
            $headers = [
                'Authorization' => 'Token ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ];
            // Send POST request to create a draft email
            $response = $client->post($path, [
                'json' => $data,
                'headers' => $headers,
            ]);
            if ($response->getStatusCode() < 400) {
                return true;
            }
        } catch (ClientException|RequestException $e) {
            \Craft::error($e, 'buttondown');
            throw $e;
        }
    }
}
