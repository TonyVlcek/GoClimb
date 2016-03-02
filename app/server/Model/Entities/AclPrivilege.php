<?php

namespace GoClimb\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class AclPrivilege
{

	use Id;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE, unique=TRUE)
	 */
	private $name;

	/**
	 * @var AclPermission[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="AclPermission", mappedBy="role")
	 */
	private $permissions;


	public function __construct()
	{
		$this->permissions = new ArrayCollection;
	}


	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @param string $name
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}


	/**
	 * @return AclPermission[]
	 */
	public function getPermissions()
	{
		return $this->permissions->toArray();
	}


	/**
	 * @param AclPermission $permission
	 * @return $this
	 */
	public function addPermission(AclPermission $permission)
	{
		$this->permissions->add($permission);
		return $this;
	}


	/**
	 * @param AclPermission $permission
	 * @return $this
	 */
	public function removePermission(AclPermission $permission)
	{
		$this->permissions->removeElement($permission);
		return $this;
	}

}
