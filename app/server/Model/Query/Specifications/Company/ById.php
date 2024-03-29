<?php

namespace GoClimb\Model\Query\Specifications\Company;

use Kdyby\Doctrine\QueryBuilder;
use GoClimb\Model\Query\IFilter;


class ById implements IFilter
{

	/** @var int */
	private $id;


	public function __construct($id)
	{
		$this->id = (int) $id;
	}


	/**
	 * @inheritdoc
	 */
	public function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$queryBuilder->setParameter('companyId', $this->id);
		return $queryBuilder->expr()->eq($entityAlias . '.id', ':companyId');
	}
}
