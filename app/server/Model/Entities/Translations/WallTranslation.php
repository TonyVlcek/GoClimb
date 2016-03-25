<?php

namespace GoClimb\Model\Entities;

use GoClimb\Model\Entities\Attributes\Id;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class WallTranslation
{

	use Id;

	/**
	 * @var string|NULL
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $description;


	/**
	 * @return string|NULL
	 */
	public function getDescription()
	{
		return $this->description;
	}


	/**
	 * @param string|NULL $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

}
