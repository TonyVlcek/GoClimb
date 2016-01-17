<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Query;

use Doctrine\ORM\Query\Expr\Base;
use Kdyby\Doctrine\QueryBuilder;


interface IFilter
{

	/**
	 * @param QueryBuilder $queryBuilder
	 * @param string $entityAlias
	 * @return Base
	 */
	function applyFilter(QueryBuilder $queryBuilder, $entityAlias);

}
