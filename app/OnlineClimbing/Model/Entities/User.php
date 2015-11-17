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
	 * @var Wall[]
	 * @ORM\ManyToMany(targetEntity="Wall", inversedBy="userFavorites")
	 * @ORM\JoinTable(name="user_favorite_wall")
	 */
	private $wallFavorites;

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
		$this->wallFavorites = new ArrayCollection;
	}


	/**
	 * @param Wall $wall
	 * @return $this
	 */
	public function addFavoriteWall(Wall $wall)
	{
		$this->wallFavorites->add($wall);
		return $this;
	}


	/**
	 * @param Wall $wall
	 * @return $this
	 */
	public function removeFavouriteWall(Wall $wall)
	{
		$this->wallFavorites->remove($wall);
		return $this;
	}


	/**
	 * @param Wall $wall
	 * @return bool
	 */
	public function hasFavoriteWall(Wall $wall)
	{
		return $this->wallFavorites->contains($wall);
	}


	/**
	 * @return Wall[]
	 */
	public function getFavoritedWall()
	{
		return $this->wallFavorites->toArray();
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
