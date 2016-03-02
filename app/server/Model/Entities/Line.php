<?php

namespace GoClimb\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_name_sector", columns={"name", "sector_id"})})
 */
class Line
{

	use Id;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * @var Sector
	 * @ORM\ManyToOne(targetEntity="Sector", inversedBy="lines")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $sector;

	/**
	 * @var Route[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Route", mappedBy="line")
	 */
	private $routes;


	public function __construct()
	{
		$this->routes = new ArrayCollection;
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
	 * @return Line
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}


	/**
	 * @return Sector
	 */
	public function getSector()
	{
		return $this->sector;
	}


	/**
	 * @param Sector $sector
	 * @return Line
	 */
	public function setSector(Sector $sector)
	{
		$this->sector = $sector;
		return $this;
	}


	/**
	 * @return Route[]
	 */
	public function getRoutes()
	{
		return $this->routes->toArray();
	}


	/**
	 * @param Route $route
	 * @return $this
	 */
	public function addRoute(Route $route)
	{
		$this->routes->add($route);
		return $this;
	}


	/**
	 * @param Route $route
	 * @return $this
	 */
	public function removeRoute(Route $route)
	{
		$this->routes->removeElement($route);
		return $this;
	}
}
