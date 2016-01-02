<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Query\Specifications\User;

use Kdyby\Doctrine\QueryBuilder;
use OnlineClimbing\Model\Query\IFilter;


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
		$queryBuilder->setParameter('firstName', '%' . $this->search . '%');
		return $queryBuilder->expr()->like($entityAlias . '.firstName', ':firstName');
	}
}
