<?php

namespace GoClimb\Model\Query\Specifications\Wall;

use GoClimb\Model\Query\IFilter;
use Kdyby\Doctrine\QueryBuilder;


class ByName implements IFilter
{

	/** @var string */
	private $name;


	public function __construct($name)
	{
		$this->nick = $name;
	}


	/**
	 * @inheritdoc
	 */
	public function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$queryBuilder->setParameter('wallName', $this->name);
		return $queryBuilder->expr()->eq($entityAlias . '.name', ':wallName');
	}

}
