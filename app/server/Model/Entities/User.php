<?php

namespace GoClimb\Model\Entities;

use DateInterval;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class User
{

	use Id;

	/**
	 * @var Wall[]|ArrayCollection
	 * @ORM\ManyToMany(targetEntity="Wall", inversedBy="userFavorites")
	 * @ORM\JoinTable(name="user_favorite_wall")
	 */
	private $favoriteWalls;


	/**
	 * @var Company[]|ArrayCollection
	 * @ORM\ManyToMany(targetEntity="Company", mappedBy="users")
	 */
	private $companies;

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE, unique=TRUE, options={"default": NULL})
	 */
	private $name = NULL;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE, unique=TRUE)
	 */
	private $email;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE, length=60, options={"fixed": TRUE})
	 */
	private $password;

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE, options={"default": NULL})
	 */
	private $firstName = NULL;

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE, options={"default": NULL})
	 */
	private $lastName = NULL;

	/**
	 * @var DateTime|NULL
	 * @ORM\Column(type="datetime", nullable=TRUE, options={"default": NULL})
	 */
	private $birthDate = NULL;

	/**
	 * @var int|NULL
	 * @ORM\Column(type="integer", nullable=TRUE, options={"default": NULL})
	 */
	private $height = NULL;

	/**
	 * @var int|NULL
	 * @ORM\Column(type="integer", nullable=TRUE, options={"default": NULL})
	 */
	private $weight = NULL;

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE, options={"default": NULL})
	 */
	private $phone = NULL;

	/**
	 * @var DateTime|NULL
	 * @ORM\Column(type="datetime", nullable=TRUE, options={"default": NULL})
	 */
	private $climbingSince = NULL;

	/**
	 * @var Article[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Article", mappedBy="author")
	 */
	private $articles;

	/**
	 * @var Route[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Route", mappedBy="builder")
	 */
	private $builtRoutes;

	/**
	 * @var LoginToken[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="LoginToken", mappedBy="user", cascade={"persist"})
	 */
	private $loginTokens;

	/**
	 * @var RestToken[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="RestToken", mappedBy="user")
	 */
	private $restTokens;


	public function __construct()
	{
		$this->builtRoutes = new ArrayCollection;
		$this->articles = new ArrayCollection;
		$this->favoriteWalls = new ArrayCollection;
		$this->companies = new ArrayCollection;
		$this->loginTokens = new ArrayCollection;
		$this->restTokens = new ArrayCollection;
	}


	/**
	 * @param Wall $wall
	 * @return $this
	 */
	public function addFavoriteWall(Wall $wall)
	{
		$this->favoriteWalls->add($wall);
		return $this;
	}


	/**
	 * @param Wall $wall
	 * @return $this
	 */
	public function removeFavoriteWall(Wall $wall)
	{
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
	 * @return Company[]
	 */
	public function getCompanies()
	{
		return $this->companies->toArray();
	}


	/**
	 * @param Company $company
	 * @return $this
	 */
	public function addCompany(Company $company)
	{
		$this->companies->add($company);
		return $this;
	}


	/**
	 * @param Company $company
	 * @return $this
	 */
	public function removeCompany(Company $company)
	{
		$this->companies->removeElement($company);
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @param string|NULL $name
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
	 * @return Route[]
	 */
	public function getBuiltRoutes()
	{
		return $this->builtRoutes->toArray();
	}


	/**
	 * @param Route $route
	 * @return $this
	 */
	public function addBuiltRoute(Route $route)
	{
		$this->builtRoutes->add($route);
		return $this;
	}


	/**
	 * @param Route $route
	 * @return $this
	 */
	public function removeBuiltRoute(Route $route)
	{
		$this->builtRoutes->removeElement($route);
		return $this;
	}


	/**
	 * @return LoginToken[]
	 */
	public function getLoginTokens()
	{
		return $this->loginTokens->toArray();
	}


	/**
	 * @param LoginToken $loginToken
	 * @return $this
	 */
	public function addLoginToken(LoginToken $loginToken)
	{
		$this->loginTokens->add($loginToken);
		return $this;
	}


	/**
	 * @param LoginToken $loginToken
	 * @return $this
	 */
	public function removeLoginToken(LoginToken $loginToken)
	{
		$this->loginTokens->removeElement($loginToken);
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
	 * @return DateTime|NULL
	 */
	public function getClimbingSince()
	{
		return $this->climbingSince;
	}


	/**
	 * @param DateTime|NULL $climbingSince
	 * @return $this
	 */
	public function setClimbingSince(DateTime $climbingSince = NULL)
	{
		$this->climbingSince = $climbingSince;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}


	/**
	 * @param string $email
	 * @return $this
	 */
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}


	/**
	 * @param string|NULL $firstName
	 * @return $this
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getLastName()
	{
		return $this->lastName;
	}


	/**
	 * @param string|NULL $lastName
	 * @return $this
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getFullName()
	{
		if ($this->getFirstName() === NULL || $this->getLastName() === NULL) {
			return NULL;
		}

		return $this->getFirstName() . ' ' . $this->getLastName();
	}


	/**
	 * @return DateTime|NULL
	 */
	public function getBirthDate()
	{
		return $this->birthDate;
	}


	/**
	 * @param DateTime|NULL $birthDate
	 * @return $this
	 */
	public function setBirthDate(DateTime $birthDate = NULL)
	{
		$this->birthDate = $birthDate;
		return $this;
	}


	/**
	 * @return DateInterval|NULL
	 */
	public function getAge()
	{
		if ($this->getBirthDate()) {
			return (new DateTime)->diff($this->birthDate);
		}
		return NULL;
	}


	/**
	 * @return int|NULL
	 */
	public function getHeight()
	{
		return $this->height;
	}


	/**
	 * @param int|NULL $height
	 * @return $this
	 */
	public function setHeight($height)
	{
		$this->height = $height;
		return $this;
	}


	/**
	 * @return int|NULL
	 */
	public function getWeight()
	{
		return $this->weight;
	}


	/**
	 * @param int|NULL $weight
	 * @return $this
	 */
	public function setWeight($weight)
	{
		$this->weight = $weight;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getPhone()
	{
		return $this->phone;
	}


	/**
	 * @param string|NULL $phone
	 * @return $this
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;
		return $this;
	}

}
