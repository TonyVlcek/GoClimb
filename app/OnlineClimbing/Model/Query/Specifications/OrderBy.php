<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Query\Specifications;

use Kdyby\Doctrine\QueryBuilder;
use OnlineClimbing\Model\Query\IFilter;


class OrderBy implements IFilter
{

	/** @var string */
	private $column;

	/** @var string */
	private $type;


	public function __construct($order)
	{
		if ($order) {
			list ($this->column, $this->type) = $order;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$this->type = strtoupper($this->type);
		if ($this->type === 'ASC' || $this->type === 'DESC') {
			$queryBuilder->orderBy($entityAlias . '.' . $this->column, $this->type);
		}
		return NULL;
	}
}
