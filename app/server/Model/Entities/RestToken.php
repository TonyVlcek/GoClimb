<?php

namespace GoClimb\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use GoClimb\Model\Entities\Attributes\Id;
use Nette\Utils\DateTime;


/**
 * @ORM\Entity
 */
class RestToken
{

	use Id;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="restTokens")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $user;

	/**
	 * @var Wall
	 * @ORM\ManyToOne(targetEntity="Wall", inversedBy="restTokens")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $wall;

	/**
	 * @var string
	 * @ORM\Column(type="string", unique=TRUE)
	 */
	private $token;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $remoteIp;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime")
	 */
	private $expiration;


	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}


	/**
	 * @param User $user
	 * @return $this
	 */
	public function setUser(User $user)
	{
		$this->user = $user;
		return $this;
	}


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


	/**
	 * @return string
	 */
	public function getRemoteIp()
	{
		return $this->remoteIp;
	}


	/**
	 * @param string $remoteIp
	 * @return $this
	 */
	public function setRemoteIp($remoteIp)
	{
		$this->remoteIp = $remoteIp;
		return $this;
	}


	/**
	 * @return DateTime
	 */
	public function getExpiration()
	{
		return $this->expiration;
	}


	/**
	 * @param DateTime $expiration
	 * @return $this
	 */
	public function setExpiration(DateTime $expiration)
	{
		$this->expiration = $expiration;
		return $this;
	}

}
