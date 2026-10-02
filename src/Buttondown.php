<?php

namespace studioespresso\buttondown;

use CraftCms\Cms\Form\Controls\Text;
use CraftCms\Cms\Form\Form;
use CraftCms\Cms\Form\FormContext;
use CraftCms\Cms\Form\Nodes\Field;
use CraftCms\Cms\Plugin\Plugin;
use CraftCms\Cms\Plugin\PluginSettings;
use studioespresso\buttondown\models\Settings;

use function CraftCms\Cms\t;

/**
 * Buttondown plugin
 *
 * @method Settings getSettings()
 *
 * @author Studio Espresso <support@studioespresso.co>
 * @copyright Studio Espresso
 * @license MIT
 */
class Buttondown extends Plugin
{
    public bool $hasCpSettings = true;

    protected static function createSettings(): ?PluginSettings
    {
        return new Settings;
    }

    public function settingsForm(FormContext $context = new FormContext): ?Form
    {
        return Form::make([
            Field::make(t('API key', category: 'buttondown'), Text::make('apiKey'))
                ->instructions(t('Your Buttondown API key, or an environment variable like `$BUTTONDOWN_API_KEY`', category: 'buttondown'))
                ->required(),
        ]);
    }
}
