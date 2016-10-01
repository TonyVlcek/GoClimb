<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\Repositories\AclRoleRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Rest\Mappers\RoleMapper;
use GoClimb\Model\Rest\Updaters\RoleUpdater;


class RolesPresenter extends BaseV1Presenter
{

	/** @var AclRoleRepository */
	private $aclRoleRepository;

	/** @var RoleUpdater */
	private $roleUpdater;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(AclRoleRepository $aclRoleRepository, UserRepository $userRepository, RoleUpdater $roleUpdater)
	{
		parent::__construct();

		$this->aclRoleRepository = $aclRoleRepository;
		$this->roleUpdater = $roleUpdater;
		$this->userRepository = $userRepository;
	}


	public function actionGet()
	{
		$this->checkPermissions();
		$this->addData('roles', RoleMapper::mapArray($this->aclRoleRepository->getByWall($this->wall)));
	}


	public function actionPost($id = NULL, $otherAction = NULL)
	{
		$this->checkPermissions();

		if (isset($id) && ($otherAction === 'users')) {
			$role = $this->getRoleById($id);
			$user = $this->getUserById($this->getData('userId'));

			try {
				$this->roleUpdater->addUser($role, $user);
			} catch (UniqueConstraintViolationException $e) {}

			$this->addData('users', RoleMapper::mapRolesUsers($role));
		}
	}


	public function actionDelete($id = NULL, $otherAction = NULL, $otherId = NULL)
	{
		$this->checkPermissions();

		if (($id !== NULL) && ($otherAction === 'users') && ($otherId !== NULL)) {
			$role = $this->getRoleById($id);
			$user = $this->getUserById($otherId);

			$this->roleUpdater->removeUser($role, $user);
			$this->addData('users', RoleMapper::mapRolesUsers($role));
		}
	}


	private function checkPermissions()
	{
		if (!$this->user->isAllowed(AclResource::ADMIN_ACL)) {
			$this->sendForbidden();
		}
	}


	private function getRoleById($roleId)
	{
		if (!$role = $this->aclRoleRepository->getById($roleId)) {
			$this->sendNotFound();
		}
		if ($role->getWall() !== $this->wall) {
			$this->sendNotFound();
		}

		return $role;
	}


	private function getUserById($userId)
	{
		if (!$user = $this->userRepository->getById($userId)) {
			$this->sendNotFound();
		}

		return $user;
	}

}
