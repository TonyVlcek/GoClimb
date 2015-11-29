<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\DateTime;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class LoginToken
{

	use Id;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="loginTokens", cascade={"persist"})
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $user;

	/**
	 * @var string
	 * @ORM\Column(type="string", unique=TRUE)
	 */
	private $token;

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
	public function setUser($user)
	{
		$this->user = $user;
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
