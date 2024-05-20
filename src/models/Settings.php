<?php
declare(strict_types=1);

namespace contentreactor\shipping\time\models;

use craft\base\Model;

/**
 * Content Reactor Shipping Time settings
 */
class Settings extends Model
{
	/** @var string The Country ISO Code. */
	public $countryIsoCode;

	/** @var string The Language ISO Code. */
	public $languageIsoCode;

	/** @var string The Subdivison ISO Code. */
	public $subdivisionCode;

	/** @var string The Custom Message. */
	public $customMessage;

	/** @var string The Days Count. */
	public $daysCount;

	/** @var string The Holiday Days. */
	public $holidayDays;

	/**
	 * @inheritdoc
	 */
	protected function defineRules(): array
	{
		return [
			[['countryIsoCode'], 'required'],
			[['countryIsoCode', 'languageIsoCode', 'subdivisionCode', 'customMessage', 'daysCount', 'holidayDays'], 'string'],
		];
	}
}
