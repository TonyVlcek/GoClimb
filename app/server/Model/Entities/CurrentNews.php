<?php

namespace GoClimb\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\DateTime;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class CurrentNews
{

	use Id;

	/**
	 * @var Wall|NULL
	 * @ORM\ManyToOne(targetEntity="Wall", inversedBy="news")
	 */
	private $wall;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="news")
	 */
	private $author;

	/**
	 * @var DateTime|NULL
	 * @ORM\Column(type="datetime", nullable=TRUE, options={"default": NULL})
	 */
	private $published = NULL;

	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=FALSE)
	 */
	private $content;


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
		return $this->published !== NULL;
	}


	/**
	 * @return $this
	 */
	public function publish()
	{
		$this->setPublishedDate(new DateTime);
		return $this;
	}


	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}


	/**
	 * @param string $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

}
