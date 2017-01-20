<?php
/**
 * @author Martin Mikšík
 */

namespace GoClimb\Model\Entities;

use GoClimb\Model\Entities\Attributes\Id;
use Doctrine\ORM\Mapping as ORM;
use DateTime;


/**
 * @ORM\Entity
 */
class Rating
{

	use Id;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="ratings")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $author;

	/**
	 * @var Route
	 * @ORM\ManyToOne(targetEntity="Route", inversedBy="ratings")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $route;

	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=FALSE)
	 */
	private $note;


	/**
	 * @var int
	 * @ORM\Column(type="smallint", nullable=FALSE)
	 */
	private $rating;

	/**
	 * @var DateTime|NULL
	 * @ORM\Column(type="datetime", nullable=FALSE)
	 */
	private $createdDate;


	/**
	 * @return User
	 */
	public function getAuthor()
	{
		return $this->author;
	}


	/**
	 * @param User $author
	 * @return $this
	 */
	public function setAuthor(User $author)
	{
		$this->author = $author;
		return $this;
	}


	/**
	 * @return Route
	 */
	public function getRoute()
	{
		return $this->route;
	}


	/**
	 * @param Route $route
	 * @return $this
	 */
	public function setRoute(Route $route)
	{
		$this->route = $route;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getNote()
	{
		return $this->note;
	}


	/**
	 * @param string $note
	 * @return $this
	 */
	public function setNote($note)
	{
		$this->note = $note;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getRating()
	{
		return $this->rating;
	}


	/**
	 * @param int $rating
	 * @return $this
	 */
	public function setRating($rating)
	{
		$this->rating = $rating;
		return $this;
	}


	/**
	 * @return DateTime|NULL
	 */
	public function getCreatedDate()
	{
		return $this->createdDate;
	}


	/**
	 * @param DateTime $createdDate
	 * @return $this
	 */
	public function setCreatedDate(DateTime $createdDate)
	{
		$this->createdDate = $createdDate;
		return $this;
	}

}
