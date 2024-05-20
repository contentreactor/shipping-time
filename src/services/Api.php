<?php
declare(strict_types=1);

namespace contentreactor\shipping\time\services;

use contentreactor\shipping\time\models\HolidayApi;
use Exception;
use GuzzleHttp\{
	Client,
};
use yii\base\Component;

/**
 * Api service responsible for making HTTP requests to the holiday API.
 */
class Api extends Component
{
	public const ENV_HOLIDAY_API_BASE_URL = 'HOLIDAY_API_BASE_URL';

	/**
	 * Makes an HTTP request to the given URL with the specified method and parameters.
	 *
	 * @param string $method The HTTP method (GET, POST, etc.)
	 * @param string $url The URL to send the request to
	 * @param array $params The request parameters
	 * @return string The response body
	 * @throws Exception If something goes wrong during the request
	 */
	public function makeRequest(string $method, string $url, array $params): string {
		$client = new Client();
		$result = false;
		
		try {
			$response = $client->request($method, $url, $params);
			$result = $response->getBody()->getContents();
		} catch (Exception $e) {
			throw new Exception('Something went wrong: ' . $e);
		}
		
		return $result;
	}

	/**
	 * Fetches public holidays data from the holiday API.
	 *
	 * @param string $countryIsoCode The ISO code of the country
	 * @param string $languageIsoCode The ISO code of the language
	 * @param string $subdivisionCode The subdivision code
	 * @param string $validFrom The valid from date
	 * @param string $validTo The valid to date
	 * @return object|array The response data
	 */
	public function getPublicHolidays(
		string $countryIsoCode, 
		string $languageIsoCode, 
		string $subdivisionCode,
		string $validFrom,
		string $validTo,
	): object|array {
		$url = getenv(self::ENV_HOLIDAY_API_BASE_URL) . "PublicHolidays";
		
		$holidayModel = new HolidayApi();
		$holidayModel->valid_from = $validFrom;
		$holidayModel->valid_to = $validTo;

		if ($holidayModel->validate()) {
			$responseData = $this->makeRequest('GET', $url, [
				['content-type' => 'application/json'],
				'query' => [
					'countryIsoCode' => $countryIsoCode,
					'languageIsoCode' => $languageIsoCode,
					'subdivisionCode' => $subdivisionCode,
					'validFrom' => $validFrom,
					'validTo' => $validTo,
				],
			]);
		} else {
			$responseData = json_encode($holidayModel->errors);
		}
		
		return json_decode($responseData);
	}
}
