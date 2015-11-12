<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Entities\Attributes;


trait Id
{

	/**
	 * @var integer
	 *
	 * @ORM\Id
	 * @ORM\Column(type="integer", options={"unsigned": TRUE})
	 * @ORM\GeneratedValue
	 */
	private $id;



	/**
	 * @return integer
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
