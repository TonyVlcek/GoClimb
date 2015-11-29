<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Security;

use Nette\Security\IAuthenticator;
use Nette\Security\IAuthorizator;
use Nette\Security\IUserStorage;
use Nette\Security\User as NetteUser;
use OnlineClimbing\Model\Entities\User as UserEntity;
use OnlineClimbing\Model\Repositories\UserRepository;


class User extends NetteUser
{

	/** @var UserRepository */
	private $userRepository;

	/** @var UserEntity */
	private $user;


	public function __construct(UserRepository $userRepository, IUserStorage $storage, IAuthenticator $authenticator = NULL, IAuthorizator $authorizator = NULL)
	{
		parent::__construct($storage, $authenticator, $authorizator);
		$this->userRepository = $userRepository;
	}


	/**
	 * @return Identity
	 */
	public function getIdentity()
	{
		return parent::getIdentity();
	}


	/**
	 * @return UserEntity
	 */
	public function getUserEntity()
	{
		if (!$this->user) {
			$this->user = $this->userRepository->getById($this->getIdentity()->getId());
		}
		return $this->user;
	}

}
