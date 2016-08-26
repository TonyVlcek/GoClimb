<?php

namespace GoClimb\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use DateTime;


/**
 * @ORM\Entity
 */
class Event extends Post
{
	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime", nullable=TRUE)
	 */
	private $startDate = NULL;

	/**
	 * @var DateTime|NULL
	 * @ORM\Column(type="datetime", nullable=TRUE)
	 */
	private $endDate = NULL;


	/**
	 * @return DateTime
	 */
	public function getStartDate()
	{
		return $this->startDate;
	}


	/**
	 * @param DateTime $startDate
	 * @return $this
	 */
	public function setStartDate(DateTime $startDate)
	{
		$this->startDate = $startDate;
		return $this;
	}


	/**
	 * @return DateTime|NULL
	 */
	public function getEndDate()
	{
		return $this->endDate;
	}


	/**
	 * @param DateTime|NULL $endDate
	 * @return $this
	 */
	public function setEndDate(DateTime $endDate = NULL)
	{
		$this->endDate = $endDate;
		return $this;
	}

}
