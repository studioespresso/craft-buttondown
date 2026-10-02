<?php

namespace studioespresso\buttondown\services;

use CraftCms\Cms\Support\Env;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use studioespresso\buttondown\Buttondown;

class SubscriberService
{
    /**
     * Error code for when a subscriber is already subscribed
     */
    private const CODE_ALREADY_SUBSCRIBED = 'email_already_exists';

    public function add(string $email, array $fields = [], array $tags = []): bool
    {
        try {
            $response = Http::baseUrl('https://api.buttondown.com/v1/')
                ->withToken((string) Env::parse(Buttondown::getInstance()->getSettings()->apiKey), 'Token')
                ->acceptJson()
                ->timeout(10)
                ->post('subscribers', [
                    'email_address' => $email,
                    'metadata' => (object) $fields,
                    'tags' => $tags,
                ]);
        } catch (ConnectionException $e) {
            Log::error($e->getMessage(), ['plugin' => 'buttondown']);

            return false;
        }

        if ($response->successful()) {
            return true;
        }

        // Already subscribed counts as a success
        if ($response->status() === 400 && $response->json('code') === self::CODE_ALREADY_SUBSCRIBED) {
            return true;
        }

        Log::error($response->json('detail') ?? $response->body(), ['plugin' => 'buttondown']);

        return false;
    }
}
