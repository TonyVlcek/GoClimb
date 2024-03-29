<?php

namespace GoClimb\Model\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"rope" = "Rope", "boulder" = "Boulder", "news" = "News"})
 */
abstract class Route
{

	use Id;

	/**
	 * @var Line
	 * @ORM\ManyToOne(targetEntity="Line", inversedBy="routes")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $line;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="builtRoutes")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $builder;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	private $name;

	/**
	 * @var Difficulty
	 * @ORM\ManyToOne(targetEntity="Difficulty")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $difficulty;

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $description;

	/**
	 * @var DateTime|NULL
	 * @ORM\Column(type="datetime", nullable=TRUE)
	 */
	private $dateCreated;

	/**
	 * @var DateTime|NULL
	 * @ORM\Column(type="datetime", nullable=TRUE)
	 */
	private $dateRemoved;

	/**
	 * @var Color[]|ArrayCollection
	 * @ORM\ManyToMany(targetEntity="Color", cascade={"persist"})
	 * @ORM\JoinTable(name="route_color")
	 */
	private $colors;

	/**
	 * @var Log[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Log", mappedBy="route")
	 */
	private $logs;

	/**
	 * @var RouteParameter[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="RouteParameter", mappedBy="route", cascade={"persist"}, orphanRemoval=TRUE)
	 */
	private $routeParameters;

	/**
	 * @var Rating[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Rating", mappedBy="route")
	 */
	private $ratings;


	public function __construct()
	{
		$this->colors = new ArrayCollection;
		$this->routeParameters = new ArrayCollection;
		$this->logs = new ArrayCollection;
		$this->ratings = new ArrayCollection;
	}


	/**
	 * @return Line
	 */
	public function getLine()
	{
		return $this->line;
	}


	/**
	 * @param Line $line
	 * @return $this
	 */
	public function setLine(Line $line)
	{
		$this->line = $line;
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
	 * @return User
	 */
	public function getBuilder()
	{
		return $this->builder;
	}


	/**
	 * @param User $builder
	 * @return $this
	 */
	public function setBuilder(User $builder)
	{
		$this->builder = $builder;
		return $this;
	}


	/**
	 * @return Difficulty
	 */
	public function getDifficulty()
	{
		return $this->difficulty;
	}


	/**
	 * @param Difficulty $difficulty
	 * @return $this
	 */
	public function setDifficulty(Difficulty $difficulty)
	{
		$this->difficulty = $difficulty;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getDescription()
	{
		return $this->description;
	}


	/**
	 * @param string|NULL $description
	 * @return $this
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}


	/**
	 * @return DateTime|NULL
	 */
	public function getDateCreated()
	{
		return $this->dateCreated;
	}


	/**
	 * @param DateTime|NULL $dateCreated
	 * @return $this
	 */
	public function setDateCreated(DateTime $dateCreated = NULL)
	{
		$this->dateCreated = $dateCreated;
		return $this;
	}


	/**
	 * @return DateTime|NULL
	 */
	public function getDateRemoved()
	{
		return $this->dateRemoved;
	}


	/**
	 * @param DateTime|NULL $dateRemoved
	 * @return $this
	 */
	public function setDateRemoved(DateTime $dateRemoved = NULL)
	{
		$this->dateRemoved = $dateRemoved;
		return $this;
	}


	/**
	 * @return Color[]
	 */
	public function getColors()
	{
		return $this->colors->toArray();
	}


	/**
	 * @param Color[] $colors
	 * @return $this
	 */
	public function setColors(array $colors)
	{
		$this->colors->clear();
		foreach ($colors as $color) {
			$this->colors->add($color);
		}
		return $this;
	}


	/**
	 * @return RouteParameter[]
	 */
	public function getRouteParameters()
	{
		return $this->routeParameters->toArray();
	}


	/**
	 * @param RouteParameter $routeParameter
	 * @return $this
	 */
	public function addRouteParameter($routeParameter)
	{
		$this->routeParameters->add($routeParameter);
		return $this;
	}


	/**
	 * @param RouteParameter $routeParameter
	 * @return $this
	 */
	public function removeRouteParameter($routeParameter)
	{
		$this->routeParameters->removeElement($routeParameter);
		return $this;
	}


	/**
	 * @return Log[]
	 */
	public function getLogs()
	{
		return $this->logs->toArray();
	}


	/**
	 * @return bool
	 */
	public function isRope()
	{
		return $this instanceof Rope;
	}


	/**
	 * @return bool
	 */
	public function isBoulder()
	{
		return $this instanceof Boulder;
	}

	/**
	 * @return Rating[]
	 */
	public function getRatings()
	{
		return $this->ratings->toArray();
	}


	/**
	 * @param Rating $rating
	 * @return $this
	 */
	public function addRating(Rating $rating)
	{
		$this->ratings->add($rating);
		return $this;
	}
}
