<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\UI\Grids\Company;

use Nette\Forms\Container;
use GoClimb\Model\Query\Specifications\AndArgs;
use GoClimb\Model\Query\Specifications\OrderBy;
use GoClimb\Model\Query\Specifications\User\NameLike;
use GoClimb\Model\Repositories\CompanyRepository;
use GoClimb\UI\Grids\BaseGrid;
use GoClimb\UI\Grids\ITranslatableGridFactory;


interface ICompanyGridFactory extends ITranslatableGridFactory
{

	/** @return CompanyGrid */
	function create();

}


final class CompanyGrid extends BaseGrid
{

	/** @var CompanyRepository */
	private $companyRepository;


	public function __construct(CompanyRepository $companyRepository)
	{
		parent::__construct();
		$this->companyRepository = $companyRepository;
	}


	/**
	 * @inheritdoc
	 */
	public function init()
	{
		$this->addColumn('name', 'fields.name')->enableSort();
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

		return $this->companyRepository->getBuilderByFilters($args, new OrderBy($order));
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


	/**
	 * @inheritdoc
	 */
	public function getDomain()
	{
		return 'company';
	}
}
