<?php
/**
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;
use OnlineClimbing\Model\Entities\Wall;

/**
 * @ORM\Entity
 */
class File
{
	use Id;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $path;

	/**
	 * @var Wall|NULL
	 * @ORM\ManyToOne(targetEntity="Wall", inversedBy="files")
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
	 * @return File
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}


	/**
	 * @param string $path
	 * @return File
	 */
	public function setPath($path)
	{
		$this->path = $path;
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
	 * @param Wall $wall|NULL
	 * @return File
	 */
	public function setWall(Wall $wall)
	{
		$this->wall = $wall;
		return $this;
	}

}
