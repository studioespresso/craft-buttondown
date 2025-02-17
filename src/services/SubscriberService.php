<?php

namespace studioespresso\buttondown\services;

use GuzzleHttp\Exception\GuzzleException;

class SubscriberService extends BaseApiService
{
    /**
     * @param $email
     * @return bool
     * @throws GuzzleException
     */
    public function add($email): bool
    {
        try {
            return $this->makeApiCall('subscribers', [
                'email_address' => $email,
            ]);
        } catch (GuzzleException $e) {
            return $this->handleApiError($e);
        }
    }
}
