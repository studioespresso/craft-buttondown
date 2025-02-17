<?php

namespace studioespresso\buttondown\services;

class SubscriberService extends BaseApiService
{
    public function add($email): bool
    {
        return $this->makeApiCall('subscribers', [
            'email_address' => $email,
        ]);
    }
}
