<?php
declare(strict_types=1);

namespace contentreactor\shipping\time;

use contentreactor\shipping\time\models\Settings;
use contentreactor\shipping\time\services\{
	Api,
	ShippingTime,
};
use contentreactor\shipping\time\traits\Services;
use contentreactor\shipping\time\web\twig\Extension;
use Craft;
use craft\base\{
	Model,
	Plugin as BasePlugin,
};
use craft\events\RegisterCpNavItemsEvent;
use craft\helpers\UrlHelper;
use craft\web\twig\variables\Cp;
use yii\base\Event;

/**
 * Content Reactor Shipping Time plugin
 *
 * @method static Plugin getInstance()
 * @method Settings getSettings()
 * @author Content Reactor <support@contentreactor.com>
 * @copyright Content Reactor
 * @license MIT
 * @property-read Api $api
 * @property-read ShippingTime $shippingTime
 */
class Plugin extends BasePlugin
{
	use Services;

	public string $schemaVersion = '1.0.0';
	public bool $hasCpSettings = true;

	public static function config(): array
	{
		return [
			'components' => [
				'api' => Api::class,
				'shippingTime' => ShippingTime::class,
			],
		];
	}

	public function init(): void
	{
		parent::init();

		// $this->_navigation();
		Craft::$app->getView()->registerTwigExtension(new Extension);

	}

	protected function createSettingsModel(): ?Model
	{
		return Craft::createObject(Settings::class);
	}

	protected function settingsHtml(): ?string
	{
		return Craft::$app->getResponse()->redirect(UrlHelper::cpUrl('contentreactor-shipping-time/settings'))->send();
	}

	protected function _navigation()
	{
		Event::on(
			Cp::class,
			Cp::EVENT_REGISTER_CP_NAV_ITEMS,
			function(RegisterCpNavItemsEvent $event) {
				$event->navItems[] = [
					'url' => 'contentreactor-shipping-time/settings',
					'label' => 'ContentReactor Shipping Time',
					'icon' => '@yourplugin/icon.svg',
				];
			}
		);
	}
}
