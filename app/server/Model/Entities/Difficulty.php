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
class Difficulty
{

	use Id;

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $ratingUIAA;

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $ratingFRL;

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $ratingHUECO;

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $ratingFRB;

	/**
	 * @var int
	 * @ORM\Column(type="integer", nullable=FALSE)
	 */
	private $points;


	/**
	 * @return string|NULL
	 */
	public function getRatingUIAA()
	{
		return $this->ratingUIAA;
	}


	/**
	 * @param string|NULL $ratingUIAA
	 * @return $this
	 */
	public function setRatingUIAA($ratingUIAA)
	{
		$this->ratingUIAA = $ratingUIAA;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getRatingFRL()
	{
		return $this->ratingFRL;
	}


	/**
	 * @param string|NULL $ratingFRL
	 * @return $this
	 */
	public function setRatingFRL($ratingFRL)
	{
		$this->ratingFRL = $ratingFRL;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getRatingHUECO()
	{
		return $this->ratingHUECO;
	}


	/**
	 * @param string|NULL $ratingHUECO
	 * @return $this
	 */
	public function setRatingHUECO($ratingHUECO)
	{
		$this->ratingHUECO = $ratingHUECO;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getRatingFRB()
	{
		return $this->ratingFRB;
	}


	/**
	 * @param string|NULL $ratingFRB
	 * @return $this
	 */
	public function setRatingFRB($ratingFRB)
	{
		$this->ratingFRB = $ratingFRB;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getPoints()
	{
		return $this->points;
	}


	/**
	 * @param int $points
	 * @return $this
	 */
	public function setPoints($points)
	{
		$this->points = $points;
		return $this;
	}

}
