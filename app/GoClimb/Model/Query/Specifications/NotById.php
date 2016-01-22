<?php
/**
 * @author Martin Mikšík
 */

namespace GoClimb\Model\Query\Specifications;

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
		$queryBuilder->setParameter('id', $this->id);
		return $queryBuilder->expr()->neq($entityAlias . '.id', ':id');
	}

}
