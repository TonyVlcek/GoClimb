<?php

namespace GoClimb\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_name_wall", columns={"name", "wall_id"})})
 */
class AclRole
{

	use Id;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	private $name;

	/**
	 * @var AclRole|NULL
	 * @ORM\ManyToOne(targetEntity="AclRole", inversedBy="children")
	 */
	private $parent;

	/**
	 * @var AclRole[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="AclRole", mappedBy="parent")
	 */
	private $children;

	/**
	 * @var Wall|NULL
	 * @ORM\ManyToOne(targetEntity="Wall", inversedBy="roles")
	 */
	private $wall;

	/**
	 * @var AclPermission[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="AclPermission", mappedBy="role")
	 */
	private $permissions;

	/**
	 * @var User[]|ArrayCollection
	 * @ORM\ManyToMany(targetEntity="User", inversedBy="roles")
	 * @ORM\JoinTable(name="user_role")
	 */
	private $users;


	public function __construct()
	{
		$this->children = new ArrayCollection;
		$this->permissions = new ArrayCollection;
		$this->users = new ArrayCollection;
	}


	/**
	 * @return AclRole|NULL
	 */
	public function getParent()
	{
		return $this->parent;
	}


	/**
	 * @param AclRole|NULL $parent
	 * @return $this
	 */
	public function setParent(AclRole $parent = NULL)
	{
		$this->parent = $parent;
		return $this;
	}


	/**
	 * @return AclRole[]
	 */
	public function getChildren()
	{
		return $this->children->toArray();
	}


	/**
	 * @param AclRole $role
	 * @return $this
	 */
	public function addChild(AclRole $role)
	{
		$this->children->add($role);
		return $this;
	}


	/**
	 * @param AclRole $role
	 * @return $this
	 */
	public function removeChild(AclRole $role)
	{
		$this->children->removeElement($role);
		return $this;
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
	 * @return Wall|NULL
	 */
	public function getWall()
	{
		return $this->wall;
	}


	/**
	 * @param Wall|NULL $wall
	 * @return $this
	 */
	public function setWall(Wall $wall = NULL)
	{
		$this->wall = $wall;
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


	/**
	 * @return User[]
	 */
	public function getUsers()
	{
		return $this->users->toArray();
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function addUser(User $user)
	{
		$this->users->add($user);
		return $this;
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function removeUser(User $user)
	{
		$this->users->removeElement($user);
		return $this;
	}

}
