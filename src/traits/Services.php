<?php
declare(strict_types=1);

namespace contentreactor\shipping\time\traits;

use contentreactor\shipping\time\services\{
	Api,
	ShippingTime,
};

/**
 * Trait providing methods to access various services.
 */
trait Services
{
	/**
	 * Get an instance of the API service.
	 *
	 * @return Api The API service instance
	 */
	public function getApi(): Api {
		return $this->get('api');
	}

	/**
	 * Get an instance of the ShippingTime service.
	 *
	 * @return ShippingTime The ShippingTime service instance
	 */
	public function getShippingTime(): ShippingTime {
		return $this->get('shippingTime');
	}

}
