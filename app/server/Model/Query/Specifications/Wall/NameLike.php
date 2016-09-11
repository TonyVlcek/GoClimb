<?php

namespace GoClimb\Model\Query\Specifications\Wall;

use GoClimb\Model\Query\Helpers;
use GoClimb\Model\Query\IFilter;
use Kdyby\Doctrine\QueryBuilder;


class NameLike implements IFilter
{

	/** @var string */
	private $search;


	public function __construct($search)
	{
		$this->search = (string) $search;
	}


	/**
	 * @inheritdoc
	 */
	public function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$queryBuilder->setParameter('wallName', '%' . Helpers::escapeWildcard($this->search) . '%');
		return $queryBuilder->expr()->like($entityAlias . '.name', ':wallName');
	}
}
