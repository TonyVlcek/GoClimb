<?php
/**
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
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

}
