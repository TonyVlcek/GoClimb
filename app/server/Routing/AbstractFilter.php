<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Routing;

abstract class AbstractFilter implements IFilter
{

	public function getFilterDefinition()
	{
		return [
			TranslatedRoute::FILTER_IN => [$this, 'in'],
			TranslatedRoute::FILTER_OUT => [$this, 'out'],
		];
	}

	abstract public function in(array $params);

	abstract public function out(array $params);

}
