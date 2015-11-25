<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class Route
{

	use Id;

	/**
	 * @var Line
	 * @ORM\ManyToOne(targetEntity="Line", inversedBy="routes")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $line;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	private $name;


	/**
	 * @return Line
	 */
	public function getLine()
	{
		return $this->line;
	}


	/**
	 * @param Line $line
	 * @return $this
	 */
	public function setLine(Line $line)
	{
		$this->line = $line;
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

}
