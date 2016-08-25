<?php

namespace GoClimb\Security;

use GoClimb\Model\Entities\User as UserEntity;
use Nette\Security\IIdentity;


class Identity implements IIdentity
{

	/** @var int */
	private $userId;

	/** @var string[] */
	private $roles;


	public function __construct(UserEntity $user)
	{
		$this->userId = $user->getId();

		$this->roles = array_map(function ($role) {
			return $role->getName();
		}, $user->getRoles());
	}


	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->userId;
	}


	/**
	 * @return string[]
	 */
	public function getRoles()
	{
		return $this->roles;
	}

}
