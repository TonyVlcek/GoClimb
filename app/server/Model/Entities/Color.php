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
class Color
{

	use Id;

	/**
	 * @var Wall|NULL
	 * @ORM\ManyToOne(targetEntity="Wall")
	 */
	private $wall;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	private $hash;


	/**
	 * @return Wall|NULL
	 */
	public function getWall()
	{
		return $this->wall;
	}


	/**
	 * @param Wall|NULL $wall
	 * @return $this
	 */
	public function setWall(Wall $wall)
	{
		$this->wall = $wall;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getHash()
	{
		return $this->hash;
	}


	/**
	 * @param string $hash
	 * @return $this
	 */
	public function setHash($hash)
	{
		$this->hash = $hash;
		return $this;
	}

}
