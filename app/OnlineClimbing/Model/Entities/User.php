<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class User
{

	use Id;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE, unique=TRUE)
	 */
	private $name;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE, length=60, options={"fixed": TRUE})
	 */
	private $password;

	/**
	 * @var Article[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Article", mappedBy="author")
	 */
	private $articles;


	public function __construct()
	{
		$this->articles = new ArrayCollection;
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
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}


	/**
	 * @param string $password
	 * @return $this
	 */
	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}


	/**
	 * @return ArrayCollection|Article[]
	 */
	public function getArticles()
	{
		return $this->articles;
	}


	/**
	 * @param Article $article
	 * @return $this
	 */
	public function addArticle(Article $article)
	{
		$this->articles->add($article);
		return $this;
	}


	/**
	 * @param Article $article
	 * @return $this
	 */
	public function removeArticle(Article $article)
	{
		$this->articles->remove($article);
		return $this;
	}

}
