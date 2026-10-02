<?php

namespace studioespresso\buttondown\controllers;

use CraftCms\Cms\Http\RespondsWithFlash;
use Illuminate\Http\Request;
use studioespresso\buttondown\services\SubscriberService;
use Symfony\Component\HttpFoundation\Response;

use function CraftCms\Cms\t;

class SubscriberController
{
    use RespondsWithFlash;

    public function __invoke(Request $request, SubscriberService $subscribers): Response
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'fields' => ['array'],
            'tags' => ['array'],
            'tags.*' => ['string'],
        ]);

        if (! $subscribers->add($data['email'], $data['fields'] ?? [], $data['tags'] ?? [])) {
            return $this->asFailure(t('Something went wrong', category: 'buttondown'), [
                'email' => $data['email'],
            ]);
        }

        return $this->asSuccess(t('Subscribed!', category: 'buttondown'), [
            'email' => $data['email'],
        ]);
    }
}
