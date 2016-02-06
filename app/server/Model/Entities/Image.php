<?php
/**
 * @author Martin Mikšík
 */

namespace GoClimb\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;
use GoClimb\Model\Entities\File;
use GoClimb\Model\Entities\ContentPart;


/**
 * @ORM\Entity
 */
class Image
{

	use Id;

	/**
	 * @var ContentPart|NULL
	 * @ORM\ManyToOne(targetEntity="ContentPart", inversedBy="images")
	 */
	private $contentPart;

	/**
	 * @var File
	 * @ORM\OneToOne(targetEntity="File")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $file;

	/**
	 * @var File
	 * @ORM\OneToOne(targetEntity="File")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $thumbnailFile;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $width;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $height;


	/**
	 * @return ContentPart|NULL
	 */
	public function getContentPart()
	{
		return $this->contentPart;
	}


	/**
	 * @param ContentPart|NULL $contentPart
	 * @return $this
	 */
	public function setContentPart(ContentPart $contentPart = NULL)
	{
		$this->contentPart = $contentPart;
		return $this;
	}


	/**
	 * @return File
	 */
	public function getFile()
	{
		return $this->file;
	}


	/**
	 * @param File $file
	 * @return $this
	 */
	public function setFile(File $file)
	{
		$this->file = $file;
		return $this;
	}


	/**
	 * @return File
	 */
	public function getThumbnailFile()
	{
		return $this->thumbnailFile;
	}


	/**
	 * @param File $thumbnailFile
	 * @return $this
	 */
	public function setThumbnailFile(File $thumbnailFile)
	{
		$this->thumbnailFile = $thumbnailFile;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getWidth()
	{
		return $this->width;
	}


	/**
	 * @param int $width
	 * @return $this
	 */
	public function setWidth($width)
	{
		$this->width = $width;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getHeight()
	{
		return $this->height;
	}


	/**
	 * @param int $height
	 * @return $this
	 */
	public function setHeight($height)
	{
		$this->height = $height;
		return $this;
	}

}
