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
class Page
{

	use Id;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * @var Wall|NULL
	 * @ORM\ManyToOne(targetEntity="Wall", inversedBy="pages")
	 */
	private $wall;


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
	public function setWall(Wall $wall = NULL)
	{
		$this->wall = $wall;
		return $this;
	}

}
