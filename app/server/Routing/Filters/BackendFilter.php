<?php

namespace GoClimb\Routing\Filters;

use GoClimb\Model\Entities\Company;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Repositories\CompanyRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Routing\AbstractFilter;
use Nette\Utils\Strings;


class BackendFilter extends AbstractFilter
{

	/** @var CompanyRepository */
	private $companyRepository;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(CompanyRepository $companyRepository, UserRepository $userRepository)
	{

		$this->companyRepository = $companyRepository;
		$this->userRepository = $userRepository;
	}


	public function in(array $params)
	{
		if (isset($params['id'])) {
			if (($params['presenter'] === 'Company') && ($params['action'] === 'edit')) {
				if ($company = $this->companyRepository->getById($params['id'])) {
					$params['company'] = $company;
					return $params;
				}
				return NULL;
			} elseif (($params['presenter'] === 'User') && ($params['action'] === 'edit')) {
				if ($user = $this->userRepository->getById($params['id'])) {
					$params['user'] = $user;
					return $params;
				}
				return NULL;
			}
			return $params;
		}
		return $params;
	}


	public function out(array $params)
	{
		if (($params['presenter'] === 'Company') && ($params['action'] === 'edit')){
			if ((isset($params['company'])) && ($params['company'] instanceof Company)) {
				/** @var Company $company */
				$company = $params['company'];
				unset($params['company']);
				$params['id'] = $company->getId() . "-" . Strings::webalize($company->getName());
				return $params;
			}
			return NULL;
		} elseif (($params['presenter'] === 'User') && ($params['action'] === 'edit')){
			if ((isset($params['user'])) && ($params['user'] instanceof User)) {
				/** @var User $user */
				$user = $params['user'];
				unset($params['user']);
				$params['id'] = $user->getId() . "-" . Strings::webalize($user->getName());
				return $params;
			}
			return NULL;
		}
		return $params;
	}
}
