<?php

namespace GoClimb\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class Company
{

	use Id;

	/**
	 * @var User[]|ArrayCollection
	 * @ORM\ManyToMany(targetEntity="User", inversedBy="companies")
	 * @ORM\JoinTable(name="company_user")
	 */
	private $users;

	/**
	 * @var Wall[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Wall", mappedBy="company")
	 */
	private $walls;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $name;


	public function __construct()
	{
		$this->users = new ArrayCollection;
		$this->walls = new ArrayCollection;
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


	/**
	 * @return Wall[]
	 */
	public function getWalls()
	{
		return $this->walls->toArray();
	}


	/**
	 * @param Wall $wall
	 * @return $this
	 */
	public function addWall(Wall $wall)
	{
		$this->walls->add($wall);
		return $this;
	}


	/**
	 * @param Wall $wall
	 * @return $this
	 */
	public function removeWall(Wall $wall)
	{
		$this->walls->removeElement($wall);
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

}
