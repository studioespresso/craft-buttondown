<?php

namespace studioespresso\buttondown\services;

use craft\base\Component;
use craft\helpers\Json;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use studioespresso\buttondown\Buttondown;

/**
 * Class BaseApiService
 */
class BaseApiService extends Component
{
    /**
     * @var string
     */
    private string $baseUrl = 'https://api.buttondown.com/v1/';

    /**
     * Error code for when a subscriber is already subscribed
     */
    private const CODE_ALREADY_SUBSCRIBED = 'email_already_exists';

    /**
     * @param string $path
     * @param array $data
     * @return true|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makeApiCall(string $path, array $data = [])
    {
        try {
            $client = new Client(['base_uri' => $this->baseUrl]);
            $headers = [
                // Resolved per call: the key can differ per site
                'Authorization' => 'Token ' . Buttondown::getInstance()->getSettings()->getApiKey(),
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
            throw $e;
        }
    }

    /**
     * @param $e
     * @return true
     */
    public function handleApiError($e)
    {
        $response = Json::decodeIfJson($e->getResponse()->getBody()->getContents());
        \Craft::error($response["detail"], 'buttondown');
        if ($e->getCode() === 400) {
            if ($response['code'] === self::CODE_ALREADY_SUBSCRIBED) {
                return true;
            }
        }

        throw $e;
    }
}
