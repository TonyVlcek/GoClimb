<?php

namespace GoClimb\UI\Grids;

use Kdyby\Doctrine\QueryBuilder;
use Kdyby\Translation\Translator;
use Nette\Forms\Container;
use Nette\Localization\ITranslator;
use Nette\Utils\Paginator;
use Nextras\Datagrid\Datagrid;
use GoClimb\Model\Query\Specifications\Paginate;


/**
 * @method onAttached()
 */
abstract class BaseGrid extends Datagrid
{

	/** @var array */
	public $onAttached = [];

	/** @var Translator */
	private $baseTranslator;


	public function __construct()
	{
		parent::__construct();

		$this->onAttached[] = function () {
			$this->init();
		};

		$this->setDataSourceCallback(function ($filters, $order) {
			$paginator = $this->paginator = new Paginator;
			$paginator->itemsPerPage = 50; // FIXME setter + getter
			$queryBuilder = $this->getQueryBuilder($filters, $order);
			$paginator->itemCount = $queryBuilder->select($queryBuilder->expr()->count('e.id'))->getQuery()->getSingleScalarResult();

			$queryBuilder = $this->getQueryBuilder($filters, $order);
			(new Paginate($this->paginator))->applyFilter($queryBuilder, NULL);
			return $queryBuilder->getQuery()->execute();
		});

		if ($this->getReflection()->getMethod('getFilterForm')->getFileName() !== __FILE__) {
			$this->setFilterFormFactory(function () {
				$form = $this->getFilterForm();
				$form->addSubmit('filter', 'filter.apply');
				$form->addSubmit('cancel', 'filter.cancel');
				return $form;
			});
		}

		if ($this->getReflection()->getMethod('getEditForm')->getFileName() !== __FILE__) {
			$this->setEditFormFactory([$this, 'getEditForm']);
		}

		$this->setColumnGetterCallback(function ($row, $column) {
			$method = 'get' . $column;
			return $row->$method();
		});
	}


	abstract public function init();


	/**
	 * @param array $filters
	 * @param array $order
	 * @return QueryBuilder
	 */
	abstract public function getQueryBuilder($filters, $order);


	/**
	 * @return string
	 */
	abstract public function getDomain();


	/**
	 * @return Container
	 */
	public function getFilterForm() {}


	/**
	 * @return Container
	 */
	public function getEditForm() {}


	/**
	 * @param ITranslator $translator
	 */
	public function setTranslator(ITranslator $translator)
	{
		/** @var Translator $translator */
		$this->baseTranslator = $translator->domain('grids.base');
		$this->translator = $translator->domain('grids.' . $this->getDomain());
	}


	/**
	 * @param ...$args
	 * @return string
	 */
	public function translateBase(...$args)
	{
		return $this->baseTranslator->translate(...$args);
	}


	public function createComponentForm()
	{
		return parent::createComponentForm();
	}


	public function attached($presenter)
	{
		parent::attached($presenter);
		$this->onAttached();
	}


	public function render()
	{
		$this->addCellsTemplate(__DIR__ . '/BaseGrid.latte');
		$fileName = str_replace('.php', '.latte', $this->getReflection()->getFileName());
		if (file_exists($fileName)) {
			$this->addCellsTemplate($fileName);
		}

		parent::render();
	}

}
