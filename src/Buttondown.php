<?php

namespace studioespresso\buttondown;

use CraftCms\Cms\Cp\SelectOptions;
use CraftCms\Cms\Ui\Controls\Text;
use CraftCms\Cms\Ui\Enums\ControlMode;
use CraftCms\Cms\Ui\Ui;
use CraftCms\Cms\Ui\UiContext;
use CraftCms\Cms\Ui\Nodes\Field;
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

    public function settingsUi(UiContext $context = new UiContext): ?Ui
    {
        // config/craft/buttondown.php wins over the CP value, so lock the field when it sets the key.
        $overridden = array_key_exists('apiKey', (array) config('craft.buttondown', []));

        return Ui::make([
            Field::make(t('API key', category: 'buttondown'), Text::make('apiKey')
                ->textExpanderTriggers(SelectOptions::getEnvTextExpanderTriggers())
                ->mode($overridden ? ControlMode::ReadOnly : ControlMode::Editable))
                ->instructions(t('Your Buttondown API key, or an environment variable like `$BUTTONDOWN_API_KEY`', category: 'buttondown'))
                ->warning($overridden ? t('This is being overridden by the `apiKey` setting in `config/craft/buttondown.php`.', category: 'buttondown') : null)
                ->required(),
        ]);
    }
}
