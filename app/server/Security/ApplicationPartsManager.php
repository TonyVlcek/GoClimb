<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Security;

use Nette\Http\UserStorage;
use GoClimb\Model\Entities\Wall;


class ApplicationPartsManager
{

	const BACKEND_NAMESPACE = 'GoClimb.backend';
	const AUTH_NAMESPACE = 'GoClimb.auth';
	const WALL_NAMESPACE = 'GoClimb.wall';


	/** @var UserStorage */
	private $userStorage;


	public function __construct(User $user)
	{
		$this->userStorage = $user->getStorage();
	}


	public function setAsBackend()
	{
		$this->userStorage->setNamespace(self::BACKEND_NAMESPACE);
	}


	public function setAsAuth()
	{
		$this->userStorage->setNamespace(self::AUTH_NAMESPACE);
	}


	public function setAsWallSite(Wall $wall)
	{
		$this->userStorage->setNamespace(self::WALL_NAMESPACE . '.' . $wall->getId());
	}

}
