<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Query\Specifications;

use Kdyby\Doctrine\QueryBuilder;
use OnlineClimbing\Model\Query\IFilter;


class AndArgs implements IFilter
{

	/** @var IFilter[] */
	private $filters;


	public function __construct(IFilter ...$filters)
	{
		$this->filters = $filters;
	}


	/**
	 * @param IFilter[] ...$filters
	 * @return $this
	 */
	public function add(IFilter ...$filters)
	{
		foreach ($filters as $filter) {
			$this->filters[] = $filter;
		}
		return $this;
	}


	/**
	 * @inheritdoc
	 */
	public function applyFilter(QueryBuilder $queryBuilder, $entityAlias)
	{
		$args = [];
		foreach ($this->filters as $filter) {
			$arg = $filter->applyFilter($queryBuilder, $entityAlias);
			if ($arg) {
				$args[] = $arg;
			}
		}
		if (!count($args)) {
			return NULL;
		}
		return $queryBuilder->expr()->andX(...$args);
	}

}
