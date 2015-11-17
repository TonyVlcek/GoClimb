<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\DateTime;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class Article
{
	use Id;

	/**
	 * @var Wall|NULL
	 * @ORM\ManyToOne(targetEntity="Wall", inversedBy="articles")
	 */
	private $wall;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	private $name;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="User")
	 */
	private $author;

	/**
	 * @var DateTime|NULL
	 * @ORM\Column(type="datetime", nullable=TRUE, options={"default": NULL})
	 */
	private $published = NULL;


	/**
	 * @return Wall|NULL
	 */
	public function getWall()
	{
		return $this->wall;
	}


	/**
	 * @param Wall|NULL $wall
	 * @return $this
	 */
	public function setWall(Wall $wall = NULL)
	{
		$this->wall = $wall;
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
	 * @return DateTime|NULL
	 */
	public function getPublishedDate()
	{
		return $this->published;
	}


	/**
	 * @param DateTime|NULL $publishedDate
	 * @return $this
	 */
	public function setPublishedDate(DateTime $publishedDate = NULL)
	{
		$this->published = $publishedDate;
		return $this;
	}


	/**
	 * @return bool
	 */
	public function isPublished()
	{
		return $this->published === NULL;
	}


	/**
	 * @return $this
	 */
	public function publish()
	{
		$this->published = new DateTime;
		return $this;
	}

}