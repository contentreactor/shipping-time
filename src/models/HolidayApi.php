<?php
declare(strict_types=1);

namespace contentreactor\shipping\time\models;

use craft\base\Model;

/**
 * Holiday Api model
 */
class HolidayApi extends Model
{
	/** @var date Valid From - Date. */
	public $valid_from;

	/** @var date Valid To - Date. */
	public $valid_to;
	
	/**
	 * @inheritdoc
	 */
	protected function defineRules(): array
	{
		return [
			[['valid_from', 'valid_to'], 'required'],
			[['valid_from', 'valid_to'], 'date', 'format' => 'php:Y-m-d'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'valid_from' => 'Valid From',
			'valid_to' => 'Valid To',
		];
	}
}
