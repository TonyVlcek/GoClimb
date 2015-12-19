<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\UI\Grids\Company;

use Nette\Forms\Container;
use OnlineClimbing\Model\Query\Specifications\AndArgs;
use OnlineClimbing\Model\Query\Specifications\OrderBy;
use OnlineClimbing\Model\Query\Specifications\User\NameLike;
use OnlineClimbing\Model\Repositories\CompanyRepository;
use OnlineClimbing\UI\Grids\BaseGrid;
use OnlineClimbing\UI\Grids\ITranslatableGridFactory;


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
