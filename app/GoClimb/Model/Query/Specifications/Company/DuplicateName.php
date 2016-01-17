<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Model\Query\Specifications\Company;

use Doctrine\ORM\Query\Expr\Base;
use Kdyby\Doctrine\QueryBuilder;
use GoClimb\Model\Entities\Company;
use GoClimb\Model\Query\IFilter;
use GoClimb\Model\Query\Specifications\AndArgs;
use GoClimb\Model\Query\Specifications\ById;
use GoClimb\Model\Query\Specifications\ByName;


class DuplicateName implements IFilter
{

	/** @var Company */
	private $company;


	/** @var  string */
	private $newName;


	public function __construct(Company $company, $newName)
	{
		$this->company = $company;
		$this->newName = $newName;
	}


	/**
	 * @param QueryBuilder $queryBuilder
	 * @param string $entityAlias
	 * @return Base
	 */
	public function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$args = new AndArgs(new ByName($this->newName));
		if ($this->company->getId()) {
			$args->add(new ById($this->company->getId()));
		}

		return $args->applyFilter($queryBuilder, $entityAlias);
	}

}
