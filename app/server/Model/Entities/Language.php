<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use GoClimb\Model\Entities\Attributes\Id;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class Language
{

	use Id;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $shortcut;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $const;

	/**
	 * @var WallLanguage[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="WallLanguage", mappedBy="language")
	 */
	private $wallLanguages;


	public function __construct()
	{
		$this->wallLanguages = new ArrayCollection;
	}


	/**
	 * @return string
	 */
	public function getShortcut()
	{
		return $this->shortcut;
	}


	/**
	 * @param string $shortcut
	 * @return $this
	 */
	public function setShortcut($shortcut)
	{
		$this->shortcut = $shortcut;
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
	 * @return string
	 */
	public function getConst()
	{
		return $this->const;
	}


	/**
	 * @param string $const
	 * @return $this
	 */
	public function setConst($const)
	{
		$this->const = $const;
		return $this;
	}


	/**
	 * @return WallLanguage[]
	 */
	public function getWallLanguages()
	{
		return $this->wallLanguages->toArray();
	}


	/**
	 * @param WallLanguage $wallLanguage
	 * @return $this
	 */
	public function addWallLanguage(WallLanguage $wallLanguage)
	{
		$this->wallLanguages->add($wallLanguage);
		return $this;
	}


	/**
	 * @param WallLanguage $wallLanguage
	 * @return $this
	 */
	public function removeWallLanguage(WallLanguage $wallLanguage)
	{
		$this->wallLanguages->removeElement($wallLanguage);
		return $this;
	}

}
