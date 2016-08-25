<?php

namespace GoClimb\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class AclPermission
{

	use Id;

	/**
	 * @var AclRole
	 * @ORM\ManyToOne(targetEntity="AclRole", inversedBy="permissions")
	 * @ORM\JoinColumn(nullable=FALSE, onDelete="CASCADE")
	 */
	private $role;

	/**
	 * @var AclResource
	 * @ORM\ManyToOne(targetEntity="AclResource", inversedBy="permissions")
	 * @ORM\JoinColumn(nullable=FALSE, onDelete="CASCADE")
	 */
	private $resource;

	/**
	 * @var AclPrivilege
	 * @ORM\ManyToOne(targetEntity="AclPrivilege", inversedBy="permissions")
	 * @ORM\JoinColumn(nullable=FALSE, onDelete="CASCADE")
	 */
	private $privilege;

	/**
	 * @var bool
	 * @ORM\Column(type="boolean")
	 */
	private $allowed;


	/**
	 * @return AclRole
	 */
	public function getRole()
	{
		return $this->role;
	}


	/**
	 * @param AclRole $role
	 * @return $this
	 */
	public function setRole(AclRole $role)
	{
		$this->role = $role;
		return $this;
	}


	/**
	 * @return AclResource
	 */
	public function getResource()
	{
		return $this->resource;
	}


	/**
	 * @param AclResource $resource
	 * @return $this
	 */
	public function setResource(AclResource $resource)
	{
		$this->resource = $resource;
		return $this;
	}


	/**
	 * @return AclPrivilege
	 */
	public function getPrivilege()
	{
		return $this->privilege;
	}


	/**
	 * @param AclPrivilege $privilege
	 * @return $this
	 */
	public function setPrivilege(AclPrivilege $privilege)
	{
		$this->privilege = $privilege;
		return $this;
	}


	/**
	 * @return bool
	 */
	public function isAllowed()
	{
		return $this->allowed;
	}


	/**
	 * @param bool $allowed
	 * @return $this
	 */
	public function setAllowed($allowed)
	{
		$this->allowed = $allowed;
		return $this;
	}

}
