<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Routing;

use Nette\Application\Routers\Route;


class TranslatedRoute extends Route
{

	public function __construct($mask, array $metadata, $flags = 0)
	{
		$mask = '[<locale [a-z]{2}>/]' . $mask;
		$metadata['locale'] = NULL;
		parent::__construct($mask, $metadata, $flags);
	}


}
