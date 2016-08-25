<?php

namespace GoClimb\Model\Query\Specifications\User;

use Doctrine\ORM\Query\Expr\Base;
use Kdyby\Doctrine\QueryBuilder;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Query\IFilter;
use GoClimb\Model\Query\Specifications\AndArgs;

class DuplicateEmail implements IFilter
{

	/** @var User */
	private $user;

	/** @var string */
	private $newEmail;


	public function __construct(User $user, $newEmail)
	{
		$this->user = $user;
		$this->newEmail = $newEmail;
	}


	/**
	 * @param QueryBuilder $queryBuilder
	 * @param string $entityAlias
	 * @return Base
	 */
	function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$args = new AndArgs(new ByEmail($this->newEmail));
		if ($this->user->getId()) {
			$args->add(new NotById($this->user->getId()));
		}

		return $args->applyFilter($queryBuilder, $entityAlias);
	}

}
