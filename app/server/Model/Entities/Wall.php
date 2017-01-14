<?php

namespace GoClimb\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Address;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class Wall
{

	use Id;

	use Address;

	/**
	 * @var Application|NULL
	 * @ORM\OneToOne(targetEntity="Application", mappedBy="wall", cascade={"persist"})
	 */
	private $application;

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
	 * @var AclRole[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="AclRole", mappedBy="wall", cascade={"persist"})
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

	/**
	 * @var RestToken[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="RestToken", mappedBy="wall")
	 */
	private $restTokens;

	/**
	 * @var WallLanguage|NULL
	 * @ORM\ManyToOne(targetEntity="WallLanguage", inversedBy="wall", cascade={"persist"})
	 * @ORM\JoinColumn(nullable=TRUE)
	 */
	private $primaryLanguage;

	/**
	 * @var WallLanguage[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="WallLanguage", mappedBy="wall", cascade={"persist"})
	 */
	private $wallLanguages;

	/**
	 * @var Image|NULL
	 * @ORM\ManyToOne(targetEntity="Image", inversedBy="walls")
	 */
	private $logo;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=TRUE, unique=FALSE)
	 */
	private $analyticsCode;


	public function __construct()
	{
		$this->userFavorites = new ArrayCollection;
		$this->pages = new ArrayCollection;
		$this->roles = new ArrayCollection;
		$this->articles = new ArrayCollection;
		$this->sectors = new ArrayCollection;
		$this->files = new ArrayCollection;
		$this->restTokens = new ArrayCollection;
		$this->wallLanguages = new ArrayCollection;
	}


	/**
	 * @return Application|NULL
	 */
	public function getApplication()
	{
		return $this->application;
	}


	/**
	 * @param Application|NULL $application
	 * @return $this
	 */
	public function setApplication(Application $application = NULL)
	{
		$this->application = $application;
		return $this;
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
	 * @return AclRole[]
	 */
	public function getRoles()
	{
		return $this->roles->toArray();
	}


	/**
	 * @param AclRole $role
	 * @return $this
	 */
	public function addRole(AclRole $role)
	{
		$this->roles->add($role);
		return $this;
	}


	/**
	 * @param AclRole $role
	 * @return $this
	 */
	public function removeRole(AclRole $role)
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


	/**
	 * @return RestToken[]
	 */
	public function getRestTokens()
	{
		return $this->restTokens->toArray();
	}


	/**
	 * @param RestToken $restToken
	 * @return $this
	 */
	public function addRestToken(RestToken $restToken)
	{
		$this->restTokens->add($restToken);
		return $this;
	}


	/**
	 * @param RestToken $restToken
	 * @return $this
	 */
	public function removeRestToken(RestToken $restToken)
	{
		$this->restTokens->removeElement($restToken);
		return $this;
	}


	/**
	 * @return WallLanguage|NULL
	 */
	public function getPrimaryLanguage()
	{
		return $this->primaryLanguage;
	}


	/**
	 * @param WallLanguage|NULL $primaryLanguage
	 * @return $this
	 */
	public function setPrimaryLanguage(WallLanguage $primaryLanguage = NULL)
	{
		$this->primaryLanguage = $primaryLanguage;
		return $this;
	}


	/**
	 * @param string $shortcut
	 * @return WallLanguage|NULL
	 */
	public function getWallLanguage($shortcut)
	{
		foreach ($this->getWallLanguages() as $wallLanguage) {
			if ($wallLanguage->getLanguage()->getShortcut() === $shortcut) {
				return $wallLanguage;
			}
		}
		return NULL;
	}


	/**
	 * @return WallLanguage[]
	 */
	public function getWallLanguages()
	{
		return $this->wallLanguages->toArray();
	}


	/**
	 * @param WallLanguage $wallLanguage
	 * @return $this
	 */
	public function addWallLanguage(WallLanguage $wallLanguage)
	{
		$this->wallLanguages->add($wallLanguage);
		return $this;
	}


	/**
	 * @param WallLanguage $wallLanguage
	 * @return $this
	 */
	public function removeWallLanguage(WallLanguage $wallLanguage)
	{
		$this->wallLanguages->removeElement($wallLanguage);
		return $this;
	}


	/**
	 * @param string $shortcut
	 * @return string|NULL
	 */
	public function getDescription($shortcut)
	{
		$descriptions = $this->getDescriptions();
		if (array_key_exists($shortcut, $descriptions)) {
			return $descriptions[$shortcut];
		}
		return NULL;
	}


	/**
	 * @return string[]
	 */
	public function getDescriptions()
	{
		$descriptions = [];
		foreach ($this->getWallLanguages() as $wallLanguage) {
			$descriptions[$wallLanguage->getLanguage()->getShortcut()] = $wallLanguage->getWallTranslation() ? $wallLanguage->getWallTranslation()->getDescription() : NULL;
		}

		return $descriptions;
	}


	/**
	 * @return Image|NULL
	 */
	public function getLogo()
	{
		return $this->logo;
	}


	/**
	 * @param Image|NULL $logo
	 * @return $this
	 */
	public function setLogo(Image $logo = NULL)
	{
		$this->logo = $logo;
		return $this;
	}

	/**
	 * @return string|NULL
	 */
	public function getAnalyticsCode()
	{
		return $this->analyticsCode;
	}


	/**
	 * @param string|NULL analyticsCode
	 * @return $this
	 */
	public function setAnalyticsCode($analyticsCode)
	{
		$this->analyticsCode = $analyticsCode;
		return $this;
	}

}
