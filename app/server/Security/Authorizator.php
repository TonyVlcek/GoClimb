<?php

namespace GoClimb\Security;

use GoClimb\Model\Repositories\AclPermissionRepository;
use GoClimb\Model\Repositories\AclResourceRepository;
use GoClimb\Model\Repositories\AclRoleRepository;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Security\Permission;


class Authorizator extends Permission
{

	/** @var Cache */
	private $cache;

	/** @var AclPermissionRepository */
	private $permissionRepository;

	/** @var AclRoleRepository */
	private $roleRepository;

	/** @var AclResourceRepository */
	private $resourceRepository;

	/** @var bool */
	private $initialized = FALSE;


	public function __construct(IStorage $storage, AclPermissionRepository $permissionRepository, AclRoleRepository $roleRepository, AclResourceRepository $resourceRepository)
	{
		$this->cache = new Cache($storage, Authorizator::class);
		$this->permissionRepository = $permissionRepository;
		$this->roleRepository = $roleRepository;
		$this->resourceRepository = $resourceRepository;
	}


	/**
	 * @inheritdoc
	 */
	public function isAllowed($role, $resource, $privilege = NULL)
	{
		if (!$this->initialized) {
			$this->initialize();
			$this->initialized = TRUE;
		}

		return parent::isAllowed($role, $resource, $privilege);
	}


	private function initialize()
	{
		$data = $this->loadData();
		$this->initRoles($data['roles']);
		$this->initResources($data['resources']);
		$this->initPermissions($data['permissions']);

	}


	private function loadData()
	{
		return $this->cache->load('acl', function () {
			$data = [
				'roles' => [],
				'resources' => [],
				'permissions' => [],
			];

			foreach ($this->roleRepository->getAll() as $role) {
				$data['roles'][$role->getName()] = $role->getParent() ? $role->getParent()->getName() : NULL;
			}

			foreach ($this->resourceRepository->getAll() as $resource) {
				$data['resources'][] = $resource->getName();
			}

			foreach ($this->permissionRepository->getAll() as $permission) {
				$data['permissions'][] = [
					'allowed' => $permission->isAllowed(),
					'role' => $permission->getRole()->getName(),
					'resource' => $permission->getResource()->getName(),
				];
			}

			return $data;
		});
	}


	/**
	 * @param array $roles
	 */
	private function initRoles(array $roles)
	{
		foreach ($roles as $role => $parent) {
			$this->initRole($roles, $role, $parent);
		}
	}


	/**
	 * @param array $roles
	 * @param string $role
	 * @param string $parent
	 */
	private function initRole(array $roles, $role, $parent)
	{
		if ($parent && !$this->hasRole($parent)) {
			$this->initRole($roles, $role, $roles[$parent]);
		}
		$this->addRole($role, $parent);
	}


	/**
	 * @param array $resources
	 */
	private function initResources(array $resources)
	{
		foreach ($resources as $resource) {
			$this->initResource($resource);
		}
	}


	/**
	 * @param string $resource
	 */
	private function initResource($resource)
	{
		$this->addResource($resource);
	}


	/**
	 * @param array $permissions
	 */
	private function initPermissions(array $permissions)
	{
		foreach ($permissions as $permission) {
			$this->initPermission($permission);
		}
	}


	/**
	 * @param array $permission
	 */
	private function initPermission(array $permission)
	{
		$method = $permission['allowed'] ? 'allow' : 'deny';
		$this->$method($permission['role'], $permission['resource']);
	}

}
