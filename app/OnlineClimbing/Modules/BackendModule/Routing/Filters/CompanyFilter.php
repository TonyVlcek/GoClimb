<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Modules\BackendModule\Routing\Filters;

use OnlineClimbing\Model\Entities\Company;
use OnlineClimbing\Model\Repositories\CompanyRepository;
use OnlineClimbing\Routing\AbstractFilter;


final class CompanyFilter extends AbstractFilter
{

	/** @var CompanyRepository */
	private $companyRepository;


	public function __construct(CompanyRepository $companyRepository)
	{
		$this->companyRepository = $companyRepository;
	}


	public function in(array $params)
	{
		if (isset($params['company'])) {
			list ($companyId) = explode('-', $params['company'], 2);
			if ($company = $this->companyRepository->getById($companyId)) {
				$params['company'] = $company;
				return $params;
			}
		}
		return NULL;
	}


	public function out(array $params)
	{
		if ((isset($params['company'])) && ($params['company'] instanceof Company)) {
			/** @var Company $company */
			$company = $params['company'];
			$params['company'] = $company->getId() . "-" . $company->getName();
			return $params;
		}

		return NULL;
	}

}
