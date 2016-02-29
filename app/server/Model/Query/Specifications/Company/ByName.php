<?php

namespace GoClimb\Model\Query\Specifications\Company;

use GoClimb\Model\Query\IFilter;
use Kdyby\Doctrine\QueryBuilder;


class ByName implements IFilter
{

	/** @var string */
	private $name;


	public function __construct($name)
	{
		$this->name = $name;
	}


	/**
	 * @inheritdoc
	 */
	public function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$queryBuilder->setParameter('companyName', $this->name);
		return $queryBuilder->expr()->eq($entityAlias . '.name', ':companyName');
	}

}
