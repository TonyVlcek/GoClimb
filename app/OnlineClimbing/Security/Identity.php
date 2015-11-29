<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Security;

use Nette\Security\IIdentity;
use OnlineClimbing\Model\Entities\User as UserEntity;


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
