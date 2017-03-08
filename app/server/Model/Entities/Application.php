<?php

namespace GoClimb\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class Application
{
	const BACKEND_TOKEN = 'admin';
	const APP_TOKEN = 'app';
	const GO_TRACK_TOKEN = 'go_track';

	use Id;

	/**
	 * @var Wall|NULL
	 * @ORM\OneToOne(targetEntity="Wall", inversedBy="application")
	 */
	private $wall;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	private $description;

	/**
	 * @var string
	 * @ORM\Column(type="string", unique=TRUE)
	 */
	private $token;


	/**
	 * @return NULL|Wall
	 */
	public function getWall()
	{
		return $this->wall;
	}


	/**
	 * @param NULL|Wall $wall
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
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}


	/**
	 * @param string $description
	 * @return $this
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getToken()
	{
		return $this->token;
	}


	/**
	 * @param string $token
	 * @return $this
	 */
	public function setToken($token)
	{
		$this->token = $token;
		return $this;
	}

}
