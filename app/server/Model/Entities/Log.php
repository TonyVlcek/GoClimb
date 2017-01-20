<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class Log
{

	use Id;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="logs")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $user;

	/**
	 * @var Route
	 * @ORM\ManyToOne(targetEntity="Route", inversedBy="logs")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $route;

	/**
	 * @var Style
	 * @ORM\ManyToOne(targetEntity="Style")
	 */
	private $style;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime", nullable=FALSE)
	 */
	private $loggedDate;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $description;

	/**
	 * @var int
	 * @ORM\Column(type="smallint", nullable=FALSE)
	 */
	private $tries;


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
	public function setUser(User $user)
	{
		$this->user = $user;
		return $this;
	}


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
	 * @return Style|NULL
	 */
	public function getStyle()
	{
		return $this->style;
	}


	/**
	 * @param Style|NULL $style
	 * @return $this
	 */
	public function setStyle(Style $style = NULL)
	{
		$this->style = $style;
		return $this;
	}


	/**
	 * @return DateTime
	 */
	public function getLoggedDate()
	{
		return $this->loggedDate;
	}


	/**
	 * @param DateTime $loggedDate
	 * @return $this
	 */
	public function setLoggedDate(DateTime $loggedDate)
	{
		$this->loggedDate = $loggedDate;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}


	/**
	 * @param string $description
	 * @return $this
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getTries()
	{
		return $this->tries;
	}


	/**
	 * @param int $tries
	 */
	public function setTries($tries)
	{
		$this->tries = $tries;
	}



	/**
	 * @return int|NULL
	 */
	public function getPoints()
	{
		$points = $this->getRoute()->getDifficulty()->getPoints();
		if ($this->getStyle()) {
			if ($this->getRoute()->isRope()) {
				$points += $this->getStyle()->getRopePoints();
			} elseif ($this->getRoute()->isBoulder()) {
				$points += $this->getStyle()->getBoulderPoints();
			}
		} else {
			return NULL;
		}
		return $points;
	}

}
