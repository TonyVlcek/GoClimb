<?php

namespace GoClimb\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use GoClimb\Model\Entities\Attributes\Id;



/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"article" = "Article", "event" = "Event"})
 */
abstract class Post
{

	use Id;

	/**
	 * @var Wall
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
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="articles")
	 */
	private $author;

	/**
	 * @var DateTime|NULL
	 * @ORM\Column(type="datetime", nullable=TRUE, options={"default": NULL})
	 */
	private $publishedDate = NULL;

	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=FALSE)
	 */
	private $content;


	/**
	 * @return Wall
	 */
	public function getWall()
	{
		return $this->wall;
	}


	/**
	 * @param Wall $wall
	 * @return $this
	 */
	public function setWall(Wall $wall)
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
		return $this->publishedDate;
	}


	/**
	 * @param DateTime|NULL $publishedDate
	 * @return $this
	 */
	public function setPublishedDate(DateTime $publishedDate = NULL)
	{
		$this->publishedDate = $publishedDate;
		return $this;
	}


	/**
	 * @return bool
	 */
	public function isPublished()
	{
		return $this->publishedDate !== NULL;
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
	 * @return $this
	 */
	public function setContent($content)
	{
		$this->content = $content;
		return $this;
	}

}
