<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Query\Specifications;

use Kdyby\Doctrine\QueryBuilder;
use Nette\Utils\Paginator;
use GoClimb\Model\Query\IFilter;


class Paginate implements IFilter
{

	/** @var Paginator */
	private $paginator;


	public function __construct(Paginator $paginator)
	{
		$this->paginator = $paginator;
	}


	/**
	 * @inheritdoc
	 */
	public function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$queryBuilder->setMaxResults($this->paginator->getLength());
		$queryBuilder->setFirstResult($this->paginator->getOffset());
	}
}
