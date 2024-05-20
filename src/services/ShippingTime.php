<?php
declare(strict_types=1);

namespace contentreactor\shipping\time\services;

use contentreactor\shipping\time\Plugin;
use Craft;
use yii\base\Component;

/**
 * Shipping Time service responsible for calculating shipping time.
 */
class ShippingTime extends Component
{
	/**
	 * Calculates the estimated shipping time.
	 *
	 * @return string The estimated shipping time message
	 */
	public function calculateShippingTime(): string {
		$pluginSettings = Craft::$app->getProjectConfig()->get('contentreactor-shipping-time');

		$currentDate = date('Y-m-d');
	
		$data = Plugin::getInstance()->getApi()->getPublicHolidays(
			$pluginSettings['countryIsoCode'] ?? 'AT', 
			$pluginSettings['languageIsoCode'],
			$pluginSettings['subdivisionCode'],
			date('Y-m-d') ?? '',
			date('Y-m-d', strtotime($currentDate. ' ' . $pluginSettings['daysCount']) ?? '+ 3 days') ?? '',
		);
		
		if (empty($data)) {
			$days = 2;
		} else {
			$days = 2 + (int) $pluginSettings['holidayDays'] ?? 1;
		}
		
		$message = Craft::t('contentreactor-shipping-time', $pluginSettings['customMessage'], [
			'days' => (string) $days,
		]);
		
		return $message;
	}
}