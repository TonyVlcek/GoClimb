<?php

namespace GoClimb\Model\Query\Specifications\Company;

use Kdyby\Doctrine\QueryBuilder;
use GoClimb\Model\Query\IFilter;


class NotById implements IFilter
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
		$queryBuilder->setParameter('companyNotId', $this->id);
		return $queryBuilder->expr()->neq($entityAlias . '.id', ':companyNotId');
	}

}
