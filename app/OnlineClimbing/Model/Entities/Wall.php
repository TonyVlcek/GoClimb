<?php
/**
 * @author Tomáš Blatný
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class Wall
{

	use Id;

	/**
	 * @ORM\ManyToMany(targetEntity="User", mappedBy="favoriteWalls")
	 **/
	private $favorites;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE, unique=TRUE)
	 */
	private $name;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="User")
	 */
	private $user;

	/**
	 * @var Role[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Role", mappedBy="wall")
	 */
	private $roles;


	public function __construct()
	{
		$this->favorites = new ArrayCollection;
		$this->roles = new ArrayCollection;
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function addFavorite(User $user)
	{
		$this->favorites[] = $user;
		return $this;
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function removeFavorite(User $user)
	{
		$this->favorites->removeElement($user);
		return $this;
	}


	/**
	 * @param User $user
	 * @return bool
	 */
	public function hasFavoriteUser(User $user)
	{
		return $this->favorites->contains($user);
	}


	/**
	 * @return User[]
	 */
	public function getFavorites()
	{
		return $this->favorites->toArray();
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
	 * @return Role[]
	 */
	public function getRoles()
	{
		return $this->roles->toArray();
	}


	/**
	 * @param Role $role
	 * @return $this
	 */
	public function addRole(Role $role)
	{
		$this->roles->add($role);
		return $this;
	}


	/**
	 * @param Role $role
	 * @return $this
	 */
	public function removeRole(Role $role)
	{
		$this->roles->remove($role);
		return $this;
	}


	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function setUser($user)
	{
		$this->user = $user;
		return $this;
	}

}
