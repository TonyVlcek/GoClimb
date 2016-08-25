<?php

namespace GoClimb\Model\Entities;

use GoClimb\Model\Entities\Attributes\Id;
use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\WallLanguageException;
use Nette\Utils\Validators;


/**
 * @ORM\Entity
 */
class WallLanguage
{

	use Id;

	/**
	 * @var Wall
	 * @ORM\ManyToOne(targetEntity="Wall", inversedBy="wallLanguages")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $wall;

	/**
	 * @var Language
	 * @ORM\ManyToOne(targetEntity="Language", inversedBy="wallLanguages", cascade={"persist"})
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $language;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $url;

	/**
	 * @var WallTranslation|NULL
	 * @ORM\ManyToOne(targetEntity="WallTranslation", cascade={"persist"})
	 */
	private $wallTranslation;


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
	 * @return Language
	 */
	public function getLanguage()
	{
		return $this->language;
	}


	/**
	 * @param Language $language
	 * @return $this
	 */
	public function setLanguage(Language $language)
	{
		$this->language = $language;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}


	/**
	 * @param string $url
	 * @return $this
	 * @throws WallLanguageException
	 */
	public function setUrl($url)
	{
		if (!Validators::isUrl($url)) {
			throw WallLanguageException::invalidUrl($url);
		}

		$this->url = $url;
		return $this;
	}


	/**
	 * @return WallTranslation|NULL
	 */
	public function getWallTranslation()
	{
		return $this->wallTranslation;
	}


	/**
	 * @param WallTranslation|NULL $wallTranslation
	 * @return $this
	 * @throws WallLanguageException
	 */
	public function setWallTranslation(WallTranslation $wallTranslation = NULL)
	{
		if ($this->wallTranslation === NULL) {
			$this->wallTranslation = $wallTranslation;
		} else {
			throw WallLanguageException::oneTimeSetter('wallTranslation');
		}

		return $this;
	}

}
