<?php

namespace GoClimb\Model\Query\Specifications\User;

use GoClimb\Model\Query\IFilter;
use Kdyby\Doctrine\QueryBuilder;


class ByNick implements IFilter
{

	/** @var string */
	private $nick;


	public function __construct($nick)
	{
		$this->nick = $nick;
	}


	/**
	 * @inheritdoc
	 */
	public function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$queryBuilder->setParameter('userNick', $this->nick);
		return $queryBuilder->expr()->eq($entityAlias . '.nick', ':userNick');
	}

}
