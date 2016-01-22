<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\BackendModule\Routing;

use Nette\Application\IRouter;
use GoClimb\Modules\BackendModule\Routing\Filters\CompanyFilter;
use GoClimb\Modules\BackendModule\Routing\Filters\UserFilter;
use GoClimb\Routing\FilteredTranslatedRoute;
use GoClimb\Routing\IRouterProvider;
use GoClimb\Routing\TranslatedRoute;


class BackendRouteProvider implements IRouterProvider
{

	/** @var CompanyFilter */
	private $companyFilter;

	/** @var UserFilter */
	private $userFilter;


	public function __construct(CompanyFilter $companyFilter, UserFilter $userFilter)
	{
		$this->companyFilter = $companyFilter;
		$this->userFilter = $userFilter;
	}


	/**
	 * @return IRouter[]
	 */
	public function getRoutes()
	{
		return [
			new FilteredTranslatedRoute('admin/company/edit/<company>', [
				'presenter' => 'Company',
				'action' => 'edit',
			], $this->companyFilter),
			new FilteredTranslatedRoute('admin/user/edit/<user>', [
				'presenter' => 'User',
				'action' => 'edit',
			], $this->userFilter),
			new TranslatedRoute('admin/<presenter>/<action>', [
				'presenter' => 'Dashboard',
				'action' => 'default',
			]),
		];
	}
}
