<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class User
{

	use Id;

	/**
	 * @ORM\ManyToMany(targetEntity="Wall", inversedBy="favorites")
	 * @ORM\JoinTable(name="user_wall")
	 */
	private $favoriteWalls;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE, unique=TRUE)
	 */
	private $name;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE, length=60, options={"fixed": TRUE})
	 */
	private $password;


	public function __construct()
	{
		$this->favoriteWalls = new ArrayCollection;
	}


	/**
	 * @param Wall $wall
	 * @return $this
	 */
	public function addFavouriteWall(Wall $wall)
	{
		$wall->addFavorite($this);
		$this->favoriteWalls[] = $wall;
		return $this;
	}


	/**
	 * @param Wall $wall
	 * @return $this
	 */
	public function removeFavouriteWall(Wall $wall)
	{
		$wall->removeFavorite($this);
		$this->favoriteWalls->removeElement($wall);
		return $this;
	}


	/**
	 * @param Wall $wall
	 * @return bool
	 */
	public function hasFavoriteWall(Wall $wall)
	{
		return $this->favoriteWalls->contains($wall);
	}


	/**
	 * @return Wall[]
	 */
	public function getFavoriteWalls()
	{
		return $this->favoriteWalls->toArray();
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
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}


	/**
	 * @param string $password
	 * @return $this
	 */
	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}

}
