<?php

namespace GoClimb\UI\Grids\Wall;

use Nette\Forms\Container;
use GoClimb\Model\Query\Specifications\AndArgs;
use GoClimb\Model\Query\Specifications\OrderBy;
use GoClimb\Model\Query\Specifications\Wall\NameLike;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\UI\Grids\BaseGrid;
use GoClimb\UI\Grids\ITranslatableGridFactory;


interface IWallGridFactory extends ITranslatableGridFactory
{

	/** @return WallGrid */
	function create();

}


class WallGrid extends BaseGrid
{


	/** @var WallRepository */
	private $wallRepository;


	public function __construct(WallRepository $wallRepository)
	{
		$this->wallRepository = $wallRepository;
		parent::__construct();
	}


	public function init()
	{
		$this->addColumn('id', 'fields.id');
		$this->addColumn('name', 'fields.name')->enableSort();
		$this->addColumn('lang', 'fields.lang');
	}


	/**
	 * @inheritdoc
	 */
	public function getQueryBuilder($filters, $order)
	{
		$args = new AndArgs;
		if (isset($filters['name'])) {
			$args->add(new NameLike($filters['name']));
		}

		return $this->wallRepository->getBuilderByFilters(
			$args,
			new OrderBy($order)
		);
	}


	/**
	 * @inheritdoc
	 */
	public function getDomain()
	{
		return 'wall';
	}


	/**
	 * @inheritdoc
	 */
	public function getFilterForm()
	{
		$form = new Container;
		$form->addText('name')
			->setAttribute('placeholder', 'filter.name');

		return $form;
	}

}
