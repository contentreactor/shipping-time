<?php
declare(strict_types=1);

namespace contentreactor\shipping\time\web\twig;

use contentreactor\shipping\time\Plugin;
use Twig\Extension\AbstractExtension;
use Twig\{
	TwigFunction,
};

/**
 * Twig extension to add custom functions.
 */
class Extension extends AbstractExtension
{
	/**
	 * Returns an array of Twig functions provided by this extension.
	 *
	 * @return TwigFunction[] The array of Twig functions
	 */
	public function getFunctions(): array
	{
		return [
			new TwigFunction('calculateShippingTime', function() {
				echo Plugin::getInstance()->getShippingTime()->calculateShippingTime();
			}),
		];
	}
}
