<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Routing\Filters;

use GoClimb\Model\Facades\AuthFacade;
use GoClimb\Modules\BasePresenter;
use GoClimb\Routing\AbstractFilter;


class AuthFilter extends AbstractFilter
{

	/** @var AuthFacade */
	private $authFacade;


	public function __construct(AuthFacade $authFacade)
	{
		$this->authFacade = $authFacade;
	}


	/**
	 * @inheritdoc
	 */
	public function in(array $params)
	{
		if ((!$application = $this->authFacade->getApplicationByToken($params['token'])) || (!$params['back'])) {
			return NULL;
		}

		$params['application'] = $application;
		return $params;
	}


	/**
	 * @inheritdoc
	 */
	public function out(array $params)
	{
		var_dump($params);
		if ((!$application = $this->authFacade->getApplicationByToken($params['token'])) || (!$params['back'])) {
			return NULL;
		}

		if (($params['action'] === 'login') && strpos($params['back'], BasePresenter::TOKEN_PLACEHOLDER) === FALSE) {
			return NULL;
		}

		return $params;
	}

}
