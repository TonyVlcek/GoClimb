<?php
/**
 * @author Martin Mikšík
 */
namespace GoClimb\Model\Query\Specifications\User;

use Doctrine\ORM\Query\Expr\Base;
use Kdyby\Doctrine\QueryBuilder;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Query\IFilter;
use GoClimb\Model\Query\Specifications\AndArgs;


class DuplicateName implements IFilter
{

	/** @var User */
	private $user;

	/** @var string */
	private $newName;


	public function __construct(User $user, $newName)
	{
		$this->user = $user;
		$this->newName = $newName;
	}


	/**
	 * @param QueryBuilder $queryBuilder
	 * @param string $entityAlias
	 * @return Base
	 */
	function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$args = new AndArgs(new ByName($this->newName));
		if ($this->user->getId()) {
			$args->add(new NotById($this->user->getId()));
		}

		return $args->applyFilter($queryBuilder, $entityAlias);
	}

}
