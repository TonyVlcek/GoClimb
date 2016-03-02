<?php

namespace GoClimb\Routing;

use Nette\Application\Routers\Route;


abstract class AbstractFilter implements IFilter
{

	public function getFilterDefinition()
	{
		return [
			Route::FILTER_IN => [$this, 'in'],
			Route::FILTER_OUT => [$this, 'out'],
		];
	}

	abstract public function in(array $params);

	abstract public function out(array $params);

}
