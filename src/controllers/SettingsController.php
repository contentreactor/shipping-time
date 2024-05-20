<?php
declare(strict_types=1);

namespace contentreactor\shipping\time\controllers;

use contentreactor\shipping\time\models\Settings;
use Craft;
use craft\web\Controller;
use yii\web\Response;

/**
 * Settings controller
 */
class SettingsController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public $defaultAction = 'index';
	
	/**
	 * @inheritdoc
	 */
	protected array|int|bool $allowAnonymous = self::ALLOW_ANONYMOUS_NEVER;

	/**
	 * Displays the settings page.
	 *
	 * @return Response
	 */
	public function actionIndex(): Response
	{
		$settings = $this->getSettingsModel();
		return $this->renderTemplate('contentreactor-shipping-time/settings', [
			'settings' => $settings,
		]);
	}

	/**
	 * Retrieves the plugin settings model.
	 *
	 * @return Settings The plugin settings model.
	 */
	private function getSettingsModel(): Settings
	{
		$plugin = Craft::$app->plugins->getPlugin('contentreactor-shipping-time');
		return $plugin->getSettings();
	}

	/**
	 * Saves the plugin settings.
	 *
	 * @return Response The response to be sent.
	 */
	public function actionSaveSettings(): Response
	{
		$this->requirePostRequest();
		$params = Craft::$app->getRequest()->getBodyParams();

		$settingsForm = new Settings();
		$settingsForm->countryIsoCode = $params['countryIsoCode'];
		$settingsForm->languageIsoCode = $params['languageIsoCode'];
		$settingsForm->subdivisionCode = $params['subdivisionCode'];
		$settingsForm->customMessage = $params['customMessage'];
		$settingsForm->daysCount = $params['daysCount'];
		$settingsForm->holidayDays = $params['holidayDays'];
		
		Craft::$app->getProjectConfig()->set('contentreactor-shipping-time', $settingsForm->toArray(), Craft::t('contentreactor-shipping-time', 'Update Content Reactor Shipping Time settings.'));

		$this->setSuccessFlash(Craft::t('contentreactor-shipping-time', 'Content Reactor Shipping Time settings saved'));
	
		return $this->redirectToPostedUrl();
	}
}
