<?php

namespace GoClimb\Model\Entities\Attributes;

trait Id
{

	/**
	 * @var int
	 *
	 * @ORM\Id
	 * @ORM\Column(type="integer", options={"unsigned": TRUE})
	 * @ORM\GeneratedValue
	 */
	private $id;


	/**
	 * @return int
	 */
	final public function getId()
	{
		return $this->id;
	}


	public function __clone()
	{
		$this->id = NULL;
	}

}
