<?php

namespace GoClimb\Model\Query\Specifications\User;

use Kdyby\Doctrine\QueryBuilder;
use GoClimb\Model\Query\IFilter;


class ByIds implements IFilter
{

	/** @var int[] */
	private $ids;


	public function __construct(array $ids)
	{
		$this->ids = array_map(function ($id) {
			return (int) $id;
		}, $ids);
	}


	/**
	 * @inheritdoc
	 */
	public function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$queryBuilder->setParameter('userIds', $this->ids);
		return $queryBuilder->expr()->in($entityAlias . '.id', ':userIds');
	}
}
