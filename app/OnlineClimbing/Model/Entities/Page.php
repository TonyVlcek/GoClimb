<?php
/**
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class Page
{

	use Id;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * @var Wall|NULL
	 * @ORM\ManyToOne(targetEntity="Wall", inversedBy="pages")
	 */
	private $wall;

	/**
	 * @var ContentPart[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="ContentPart", mappedBy="page")
	 */
	private $contentParts;


	public function __construct()
	{
		$this->contentParts = new ArrayCollection;
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
	 * @return ContentPart[]
	 */
	public function getContentParts()
	{
		return $this->contentParts->toArray();
	}


	/**
	 * @param ContentPart $contentPart
	 * @return $this
	 */
	public function addContentPart(ContentPart $contentPart)
	{
		$this->contentParts->add($contentPart);
		return $this;
	}


	/**
	 * @param ContentPart $contentPart
	 * @return $this
	 */
	public function removeContentPart(ContentPart $contentPart)
	{
		$this->contentParts->removeElement($contentPart);
		return $this;
	}

}
