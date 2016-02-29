<?php

namespace GoClimb\Security;

use GoClimb\Model\Entities\User as UserEntity;
use Nette\Security\IIdentity;


class Identity implements IIdentity
{

	/** @var int */
	private $userId;


	public function __construct(UserEntity $user)
	{
		$this->userId = $user->getId();
	}


	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->userId;
	}


	/**
	 * @return array
	 */
	public function getRoles()
	{
		return [];
	}

}
