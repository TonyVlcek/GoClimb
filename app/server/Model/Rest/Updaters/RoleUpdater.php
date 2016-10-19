<?php

namespace GoClimb\Model\Rest\Updaters;

use GoClimb\Model\Entities\AclRole;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Repositories\AclRoleRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Security\Authorizator;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;

class RoleUpdater
{

	/** @var AclRoleRepository */
	private $aclRoleRepository;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(AclRoleRepository $aclRoleRepository, UserRepository $userRepository, IStorage $storage)
	{
		$this->cache = new Cache($storage, Authorizator::class);
		$this->aclRoleRepository = $aclRoleRepository;
		$this->userRepository = $userRepository;
	}


	/**
	 * @param AclRole $role
	 * @param User $user
	 */
	public function addUser(AclRole $role, User $user)
	{
		$role->addUser($user);
		$user->addRole($role);

		$this->aclRoleRepository->save($role, FALSE);
		$this->userRepository->save($user);
		$this->cache->remove('acl');
	}


	public function removeUser(AclRole $role, User $user)
	{
		$role->removeUser($user);
		$user->removeRole($role);

		$this->aclRoleRepository->save($role, FALSE);
		$this->userRepository->save($user);
		$this->cache->remove('acl');
	}

}
