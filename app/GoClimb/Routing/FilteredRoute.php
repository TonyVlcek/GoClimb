<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Routing;

class FilteredTranslatedRoute extends TranslatedRoute
{

	public function __construct($mask, array $metadata, IFilter $filter, $flags = 0)
	{
		$metadata[NULL] = $filter->getFilterDefinition();
		parent::__construct($mask, $metadata, $flags);
	}

}
