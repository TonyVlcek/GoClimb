<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Model\Query\Specifications\User;

use Kdyby\Doctrine\QueryBuilder;
use GoClimb\Model\Query\IFilter;


class ByEmail implements IFilter
{

	/** @var string */
	private $email;


	public function __construct($email)
	{
		$this->email = $email;
	}


	/**
	 * @inheritdoc
	 */
	public function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$queryBuilder->setParameter('userEmail', $this->email);
		return $queryBuilder->expr()->eq($entityAlias . '.email', ':userEmail');
	}

}
