<?php
declare(strict_types=1);

namespace contentreactor\shipping\time\controllers;

use contentreactor\shipping\time\services\Api as ApiService;
use craft\web\{
	Controller,
	Response,
};
use yii\BaseYii;

/**
 * Api controller
 */
class ApiController extends Controller
{
	/**
	 * Plugin handle.
	 */
	public const PLUGIN_HANDLE = 'contentreactor-shipping-time';
	
	/**
	 * @inheritdoc
	 */
	public $defaultAction = 'index';
	
	/**
	 * @inheritdoc
	 */
	protected array|int|bool $allowAnonymous = self::ALLOW_ANONYMOUS_LIVE;

	/**
	 * @var ApiService The api service instance.
	 */
	private ApiService $apiService;

	/**
	 * @var BaseYii Project config.
	 */
	private BaseYii $baseYii;

	/**
	 * Constructor.
	 *
	 * @param string $id
	 * @param $module
	 * @param ApiService $apiService The API service instance
	 * @param BaseYii $baseYii The BaseYii instance
	 * @param array $config
	 */
	public function __construct(
		string $id,
		$module,
		ApiService $apiService,
		BaseYii $baseYii,
		array $congig = []
	) {
		$this->apiService = $apiService;
		$this->baseYii = $baseYii;

		parent::__construct($id, $module, $congig);
	}
	
	/**
	 * Action to retrieve holidays from the API.
	 */
	public function actionGetHolidays(): Response 
	{
		$pluginSettings = $this->baseYii::$app->getProjectConfig()->get(self::PLUGIN_HANDLE);
		$params = $this->baseYii::$app->getRequest()->getBodyParams();

		$data = $this->apiService->getPublicHolidays(
			$pluginSettings['countryIsoCode'] ?? 'AT', 
			$pluginSettings['languageIsoCode'],
			$pluginSettings['subdivisionCode'],
			$params['validFrom'] ?? '',
			$params['validTo'] ?? '',
		);

		return $this->asJson($data);
		
	}
}
