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
	 * @var User[]
	 * @ORM\ManyToMany(targetEntity="User", mappedBy="wallFavorites")
	 **/
	private $userFavorites;

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

	/**
	 * @var Article[]|ArrayCollection
	 * @ORM\OneToOne(targetEntity="Article", mappedBy="wall")
	 */
	private $articles;

	public function __construct()
	{
		$this->userFavorites = new ArrayCollection;
		$this->roles = new ArrayCollection;
		$this->articles = new ArrayCollection;
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function addUserFavorite(User $user)
	{
		$this->userFavorites->add($user);
		return $this;
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function removeUserFavorite(User $user)
	{
		$this->userFavorites->remove($user);
		return $this;
	}


	/**
	 * @param User $user
	 * @return bool
	 */
	public function hasUserFavorited(User $user)
	{
		return $this->userFavorites->contains($user);
	}


	/**
	 * @return User[]
	 */
	public function getUserFavorited()
	{
		return $this->userFavorites->toArray();
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function addUserFavorite(User $user)
	{
		$this->userFavorites->add($user);
		return $this;
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function removeUserFavorite(User $user)
	{
		$this->userFavorites->remove($user);
		return $this;
	}


	/**
	 * @param User $user
	 * @return bool
	 */
	public function hasUserFavorited(User $user)
	{
		return $this->userFavorites->contains($user);
	}


	/**
	 * @return User[]
	 */
	public function getUserFavorited()
	{
		return $this->userFavorites->toArray();
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


	/**
	 * @return Article[]
	 */
	public function getArticles()
	{
		return $this->articles->toArray();
	}


	/**
	 * @param Article $article
	 * @return $this
	 */
	public function addArticle(Article $article)
	{
		$this->articles->add($article);
		return $this;
	}


	/**
	 * @param Article $article
	 * @return $this
	 */
	public function removeArticle(Article $article)
	{
		$this->articles->remove($article);
		return $this;
	}
}
