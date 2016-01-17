<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Query\Specifications\User;

use Kdyby\Doctrine\QueryBuilder;
use GoClimb\Model\Query\Helpers;
use GoClimb\Model\Query\IFilter;


class FirstNameLike implements IFilter
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
		$queryBuilder->setParameter('firstName', '%' . Helpers::escapeWildcard($this->search) . '%');
		return $queryBuilder->expr()->like($entityAlias . '.firstName', ':firstName');
	}
}
