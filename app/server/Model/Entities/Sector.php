<?php

namespace GoClimb\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_name_wall", columns={"name", "wall_id"})})
 */
class Sector
{

	use Id;

	/**
	 * @var Line[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Line", mappedBy="sector")
	 */
	private $lines;

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


	public function __construct()
	{
		$this->lines = new ArrayCollection;
	}


	/**
	 * @return Line[]
	 */
	public function getLines()
	{
		return $this->lines->toArray();
	}


	/**
	 * @param Line $line
	 * @return $this
	 */
	public function addLine(Line $line)
	{
		$this->lines->add($line);
		return $this;
	}


	/**
	 * @param Line $line
	 * @return $this
	 */
	public function removeLine(Line $line)
	{
		$this->lines->removeElement($line);
		return $this;
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
