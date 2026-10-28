<?php

namespace studioespresso\buttondown\services;

use GuzzleHttp\Exception\GuzzleException;

class SubscriberService extends BaseApiService
{
    /**
     * @param string $email
     * @param array $fields
     * @param array $tags
     * @return bool
     * @throws GuzzleException
     */
    public function add(string $email, array $fields = [], array $tags = []): bool
    {
        try {
            return $this->makeApiCall('subscribers', [
                'email_address' => $email,
                // Cast so an empty array is sent as {}: Buttondown rejects metadata `[]` with a 422
                'metadata' => (object)$fields,
                'tags' => $tags,
            ]);
        } catch (GuzzleException $e) {
            return $this->handleApiError($e);
        }
    }
}
