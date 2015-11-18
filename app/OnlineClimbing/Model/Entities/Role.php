<?php
/**
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_name_wall", columns={"name", "wall_id"})})
 */
class Role
{

	use Id;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	private $name;

	/**
	 * @var Role|NULL
	 * @ORM\ManyToOne(targetEntity="Role", inversedBy="children")
	 */
	private $parent;

	/**
	 * @var Role[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Role", mappedBy="parent")
	 */
	private $children;

	/**
	 * @var Wall|NULL
	 * @ORM\ManyToOne(targetEntity="Wall", inversedBy="roles")
	 */
	private $wall;


	public function __construct()
	{
		$this->children = new ArrayCollection;
	}


	/**
	 * @return Role|NULL
	 */
	public function getParent()
	{
		return $this->parent;
	}


	/**
	 * @param Role|NULL $parent
	 * @return Role
	 */
	public function setParent(Role $parent = NULL)
	{
		$this->parent = $parent;
		return $this;
	}


	/**
	 * @return Role[]
	 */
	public function getChildren()
	{
		return $this->children->toArray();
	}


	/**
	 * @param Role $role
	 * @return $this
	 */
	public function addChild(Role $role)
	{
		$this->children->add($role);
		return $this;
	}


	/**
	 * @param Role $role
	 * @return $this
	 */
	public function removeChild(Role $role)
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
	 * @return Role
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
	 * @return Role
	 */
	public function setWall(Wall $wall = NULL)
	{
		$this->wall = $wall;
		return $this;
	}

}
