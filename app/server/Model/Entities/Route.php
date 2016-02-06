<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


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
	 * @var User
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="builtRoutes")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $builder;

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


	/**
	 * @return User
	 */
	public function getBuilder()
	{
		return $this->builder;
	}


	/**
	 * @param User $builder
	 * @return $this
	 */
	public function setBuilder(User $builder)
	{
		$this->builder = $builder;
		return $this;
	}

}