<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Modules\BackendModule;

use OnlineClimbing\UI\Grids\Company\ICompanyGridFactory;


class CompanyPresenter extends BaseBackendPresenter
{

	/** @var ICompanyGridFactory */
	private $companyGridFactory;


	public function __construct(ICompanyGridFactory $companyGridFactory)
	{
		parent::__construct();
		$this->companyGridFactory = $companyGridFactory;
	}


	protected function createComponentCompanyGrid()
	{
		return $this->companyGridFactory->create();
	}
}
