<?php

namespace studioespresso\buttondown\models;

use CraftCms\Cms\Plugin\PluginSettings;

/**
 * Buttondown settings
 */
class Settings extends PluginSettings
{
    public ?string $apiKey = null;

    public function getRules(): array
    {
        return [
            'apiKey' => ['required', 'string'],
        ];
    }
}
