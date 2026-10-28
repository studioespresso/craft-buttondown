<?php

namespace studioespresso\buttondown\models;

use Craft;
use craft\base\Model;
use craft\helpers\App;

/**
 * Buttondown settings
 */
class Settings extends Model
{
    /**
     * @var string|array|null One API key, or one per site handle (config file only), e.g.
     * `['default' => '$BUTTONDOWN_API_KEY', 'siteHandle' => '$OTHER_KEY']`. `default` is used for sites without their own key.
     */
    public null|string|array $apiKey = null;

    /**
     * The API key for a site (the current site by default), with environment variables resolved.
     */
    public function getApiKey(?string $siteHandle = null): ?string
    {
        $apiKey = $this->apiKey;
        if (is_array($apiKey)) {
            $siteHandle ??= Craft::$app->getSites()->getCurrentSite()->handle;
            $apiKey = $apiKey[$siteHandle] ?? $apiKey['default'] ?? null;
        }

        return App::parseEnv($apiKey);
    }
}
