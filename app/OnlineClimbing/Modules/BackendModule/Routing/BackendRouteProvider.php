<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Modules\BackendModule\Routing;

use Nette\Application\IRouter;
use OnlineClimbing\Modules\BackendModule\Routing\Filters\CompanyFilter;
use OnlineClimbing\Routing\FilteredTranslatedRoute;
use OnlineClimbing\Routing\IRouterProvider;
use OnlineClimbing\Routing\TranslatedRoute;


class BackendRouteProvider implements IRouterProvider
{

	/** @var CompanyFilter */
	private $companyFilter;


	public function __construct(CompanyFilter $companyFilter)
	{
		$this->companyFilter = $companyFilter;
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
			new TranslatedRoute('admin/<presenter>/<action>', [
				'presenter' => 'Dashboard',
				'action' => 'default',
			]),
		];
	}
}
