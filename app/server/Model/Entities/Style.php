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
class Style
{

	use Id;


	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	private $name;


	/**
	 * @var integer|NULL
	 * @ORM\Column(type="integer", nullable=TRUE)
	 */
	private $ropePoints;


	/**
	 * @var integer|NULL
	 * @ORM\Column(type="integer", nullable=TRUE)
	 */
	private $boulderPoints;


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
	 * @return int|NULL
	 */
	public function getRopePoints()
	{
		return $this->ropePoints;
	}


	/**
	 * @param int|NULL $ropePoints
	 * @return $this
	 */
	public function setRopePoints($ropePoints)
	{
		$this->ropePoints = $ropePoints;
		return $this;
	}


	/**
	 * @return int|NULL
	 */
	public function getBoulderPoints()
	{
		return $this->boulderPoints;
	}


	/**
	 * @param int|NULL $boulderPoints
	 * @return $this
	 */
	public function setBoulderPoints($boulderPoints)
	{
		$this->boulderPoints = $boulderPoints;
		return $this;
	}

}
