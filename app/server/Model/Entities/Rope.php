<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Entities;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class Rope extends Route
{

	/**
	 * @var integer|NULL
	 * @ORM\Column(type="integer", nullable=TRUE)
	 */
	private $length;

	/**
	 * @var integer|NULL
	 * @ORM\Column(type="integer", nullable=TRUE)
	 */
	private $steps;


	/**
	 * @return int|NULL
	 */
	public function getLength()
	{
		return $this->length;
	}


	/**
	 * @param int|NULL $length
	 * @return $this
	 */
	public function setLength($length)
	{
		$this->length = $length;
		return $this;
	}


	/**
	 * @return int|NULL
	 */
	public function getSteps()
	{
		return $this->steps;
	}


	/**
	 * @param int|NULL $steps
	 * @return $this
	 */
	public function setSteps($steps)
	{
		$this->steps = $steps;
		return $this;
	}

}
