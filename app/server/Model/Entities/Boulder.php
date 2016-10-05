<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Entities;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class Boulder extends Route
{

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $start;

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $end;


	/**
	 * @return string|NULL
	 */
	public function getStart()
	{
		return $this->start;
	}


	/**
	 * @param string|NULL $start
	 * @return $this
	 */
	public function setStart($start)
	{
		$this->start = $start;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getEnd()
	{
		return $this->end;
	}


	/**
	 * @param string|NULL $end
	 * @return $this
	 */
	public function setEnd($end)
	{
		$this->end = $end;
		return $this;
	}


}
