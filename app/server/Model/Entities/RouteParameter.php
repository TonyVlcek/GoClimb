<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class RouteParameter
{

	use Id;

	/**
	 * @var Route
	 * @ORM\ManyToOne(targetEntity="Route", inversedBy="routeParameters")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $route;

	/**
	 * @var Parameter
	 * @ORM\ManyToOne(targetEntity="Parameter")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $parameter;

	/**
	 * @var int
	 * @ORM\Column(type="integer", nullable=FALSE)
	 */
	private $level;


	/**
	 * @return Route
	 */
	public function getRoute()
	{
		return $this->route;
	}


	/**
	 * @param Route $route
	 * @return $this
	 */
	public function setRoute(Route $route)
	{
		$this->route = $route;
		return $this;
	}


	/**
	 * @return Parameter
	 */
	public function getParameter()
	{
		return $this->parameter;
	}


	/**
	 * @param Parameter $parameter
	 * @return $this
	 */
	public function setParameter(Parameter $parameter)
	{
		$this->parameter = $parameter;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getLevel()
	{
		return $this->level;
	}


	/**
	 * @param int $level
	 * @return $this
	 */
	public function setLevel($level)
	{
		$this->level = $level;
		return $this;
	}


	/**
	 * @return int[]
	 */
	public static function getAllowedLevels()
	{
		return range(1, 3);
	}

}
