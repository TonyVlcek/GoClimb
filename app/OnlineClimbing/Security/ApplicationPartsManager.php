<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Security;

use Nette\Http\UserStorage;
use OnlineClimbing\Model\Entities\Wall;


class ApplicationPartsManager
{

	const BACKEND_NAMESPACE = 'OnlineClimbing.backend';
	const AUTH_NAMESPACE = 'OnlineClimbing.auth';
	const WALL_NAMESPACE = 'OnlineClimbing.wall';


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
