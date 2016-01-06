<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Query\Specifications\User;

use Kdyby\Doctrine\QueryBuilder;
use OnlineClimbing\Model\Query\Helpers;
use OnlineClimbing\Model\Query\IFilter;


class LastNameLike implements IFilter
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
		$queryBuilder->setParameter('lastName', '%' . Helpers::escapeWildcard($this->search) . '%');
		return $queryBuilder->expr()->like($entityAlias . '.lastName', ':lastName');
	}
}
