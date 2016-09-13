<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Facades;

use GoClimb\Model\Entities\AclPermission;
use GoClimb\Model\Entities\AclResource;
use GoClimb\Model\Entities\AclRole;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Enums\AclResource as AclResourceEnum;
use GoClimb\Model\Enums\AclRole as AclRoleEnum;
use GoClimb\Model\Repositories\AclPermissionRepository;
use GoClimb\Model\Repositories\AclResourceRepository;
use GoClimb\Model\Repositories\AclRoleRepository;
use GoClimb\Model\Repositories\UserRepository;


class AclFacade
{


	/** @var AclRoleRepository */
	private $roleRepository;

	/** @var AclResourceRepository */
	private $resourceRepository;

	/** @var AclPermissionRepository */
	private $permissionRepository;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(AclRoleRepository $roleRepository, AclResourceRepository $resourceRepository, AclPermissionRepository $permissionRepository, UserRepository $userRepository)
	{
		$this->roleRepository = $roleRepository;
		$this->resourceRepository = $resourceRepository;
		$this->permissionRepository = $permissionRepository;
		$this->userRepository = $userRepository;
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function setGlobalOwner(User $user)
	{
		$role = $this->roleRepository->getGlobalByName(AclRoleEnum::GOCLIMB_OWNER);
		$role->addUser($user);
		$user->addRole($role);
		$this->userRepository->save($user);
		return $this;
	}


	/**
	 * @param Wall $wall
	 * @param User $user
	 * @return $this
	 */
	public function initWallRoles(Wall $wall, User $user)
	{
		$guest = $this->roleRepository->getGlobalByName(AclRoleEnum::GUEST);
		$builder = (new AclRole)->setName(AclRoleEnum::WALL_BUILDER)->setParent($guest);
		$admin = (new AclRole)->setName(AclRoleEnum::WALL_ADMIN)->setParent($builder);
		$owner = (new AclRole)->setName(AclRoleEnum::WALL_OWNER)->setParent($admin);

		$guest->addChild($builder);
		$builder->addChild($admin);
		$admin->addChild($owner);

		foreach ([$builder, $admin, $owner] as $role) {
			$wall->addRole($role);
			$role->setWall($wall);
			$this->roleRepository->save($role, FALSE);
		}

		$resources = $this->getResourcesKeyIndexed();
		$this->addPermission($builder, $resources[AclResourceEnum::ADMIN_DASHBOARD])
			->addPermission($admin, $resources[AclResourceEnum::ADMIN_ARTICLES])
			->addPermission($admin, $resources[AclResourceEnum::ADMIN_EVENTS])
			->addPermission($admin, $resources[AclResourceEnum::ADMIN_NEWS])
			->addPermission($owner, $resources[AclResourceEnum::ADMIN_SETTINGS_ADVANCED])
			->addPermission($owner, $resources[AclResourceEnum::ADMIN_ACL]);

		$user->addRole($owner);
		$owner->addUser($user);

		$this->userRepository->save($user);
		return $this;
	}


	/**
	 * @param AclRole $role
	 * @param AclResource $resource
	 * @return $this
	 */
	private function addPermission(AclRole $role, AclResource $resource)
	{
		$role->addPermission($permission = (new AclPermission)->setRole($role)->setResource($resource)->setAllowed(TRUE));
		$this->permissionRepository->save($permission, FALSE);
		return $this;
	}


	/**
	 * @return AclResource[]
	 */
	private function getResourcesKeyIndexed()
	{
		$resources = [];
		foreach ($this->resourceRepository->getAll() as $resource) {
			$resources[$resource->getName()] = $resource;
		}
		return $resources;
	}

}
