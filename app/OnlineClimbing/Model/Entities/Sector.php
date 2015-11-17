<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_name_wall", columns={"name", "wall_id"})})
 */
class Sector
{

	use Id;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	private $name;

	/**
	 * @var Wall
	 * @ORM\ManyToOne(targetEntity="Wall", inversedBy="sectors")
	 * @ORM\JoinColumn(nullable=FALSE)
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
	 * @return Wall
	 */
	public function getWall()
	{
		return $this->wall;
	}


	/**
	 * @param Wall $wall
	 * @return $this
	 */
	public function setWall($wall)
	{
		$this->wall = $wall;
		return $this;
	}

}
