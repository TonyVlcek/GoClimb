<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Modules\BackendModule\Routing\Filters;

use GoClimb\Model\Entities\User;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Routing\AbstractFilter;


final class UserFilter extends AbstractFilter
{

	/** @var UserRepository */
	private $userRepository;


	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}


	public function in(array $params)
	{
		if (isset($params['user'])) {
			list ($userId) = explode('-', $params['user'], 2);
			if ($user = $this->userRepository->getById($userId)) {
				$params['user'] = $user;
				return $params;
			}
		}
		return NULL;
	}


	public function out(array $params)
	{
		if ((isset($params['user'])) && ($params['user'] instanceof User)) {
			/** @var User $user */
			$user = $params['user'];
			$params['user'] = $user->getId() . "-" . $user->getName();
			return $params;
		}

		return NULL;
	}

}
