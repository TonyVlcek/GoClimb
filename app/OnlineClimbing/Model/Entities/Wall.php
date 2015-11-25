<?php
/**
 * @author Tomáš Blatný
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;
use OnlineClimbing\Model\Entities\File;


/**
 * @ORM\Entity
 */
class Wall
{

	use Id;

	/**
	 * @var User[]|ArrayCollection
	 * @ORM\ManyToMany(targetEntity="User", mappedBy="favoriteWalls")
	 */
	private $userFavorites;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE, unique=TRUE)
	 */
	private $name;

	/**
	 * @var Company
	 * @ORM\ManyToOne(targetEntity="Company", inversedBy="walls")
	 */
	private $company;

	/**
	 * @var Page[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Page", mappedBy="wall")
	 */
	private $pages;

	/**
	 * @var Role[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Role", mappedBy="wall")
	 */
	private $roles;

	/**
	 * @var Article[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Article", mappedBy="wall")
	 */
	private $articles;

	/**
	 * @var Sector[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Sector", mappedBy="wall")
	 */
	private $sectors;

	/**
	 * @var File[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="File", mappedBy="wall")
	 */
	private $files;


	public function __construct()
	{
		$this->userFavorites = new ArrayCollection;
		$this->pages = new ArrayCollection;
		$this->roles = new ArrayCollection;
		$this->articles = new ArrayCollection;
		$this->sectors = new ArrayCollection;
		$this->files = new ArrayCollection;
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
		$this->userFavorites->removeElement($user);
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
	public function getUsersFavorited()
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
	 * @return Page[]
	 */
	public function getPages()
	{
		return $this->pages->toArray();
	}


	/**
	 * @param Page $page
	 * @return $this
	 */
	public function addPage(Page $page)
	{
		$this->pages->add($page);
		return $this;
	}


	/**
	 * @param Page $page
	 * @return $this
	 */
	public function removePage(Page $page)
	{
		$this->pages->removeElement($page);
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
		$this->roles->removeElement($role);
		return $this;
	}


	/**
	 * @return Company
	 */
	public function getCompany()
	{
		return $this->company;
	}


	/**
	 * @param Company $company
	 * @return $this
	 */
	public function setCompany($company)
	{
		$this->company = $company;
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
		$this->articles->removeElement($article);
		return $this;
	}


	/**
	 * @return Sector[]
	 */
	public function getSectors()
	{
		return $this->sectors->toArray();
	}


	/**
	 * @param Sector $sector
	 * @return $this
	 */
	public function addSector(Sector $sector)
	{
		$this->sectors->add($sector);
		return $this;
	}


	/**
	 * @param Sector $sector
	 * @return $this
	 */
	public function removeSector(Sector $sector)
	{
		$this->sectors->removeElement($sector);
		return $this;
	}


	/**
	 * @return File[]
	 */
	public function getFiles()
	{
		return $this->files->toArray();
	}


	/**
	 * @param File $file
	 * @return $this
	 */
	public function addFile(File $file)
	{
		$this->files->add($file);
		return $this;
	}


	/**
	 * @param File $file
	 * @return $this
	 */
	public function removeFile(File $file)
	{
		$this->files->removeElement($file);
		return $this;
	}

}
