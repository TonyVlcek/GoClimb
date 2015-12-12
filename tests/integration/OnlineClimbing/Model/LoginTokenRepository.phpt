<?php
/**
 * TEST: LoginTokenRepository test
 *
 * @author Tony Vlček
 */

use Nette\Utils\DateTime;
use OnlineClimbing\Model\Entities\LoginToken;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Repositories\LoginTokenRepository;
use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class LoginTokenRepositoryTestCase extends DatabaseTestCase
{

	const ACTIVE_TOKEN = 'ACTIVE_TokenString';
	const EXPIRED_TOKEN = 'EXPIRED_TokenString';

	/** @var LoginTokenRepository */
	private $loginTokenRepository;

	/** @var UserRepository */
	private $userRepository;

	/** @var  User */
	private $user;


	public function __construct(LoginTokenRepository $loginTokenRepository, UserRepository $userRepository)
	{
		parent::__construct();
		$this->loginTokenRepository = $loginTokenRepository;
		$this->userRepository = $userRepository;

		$this->user = $this->userRepository->getById(1);
	}


	public function testGetByUser()
	{
		Assert::type(LoginToken::class, $loginToken = $this->loginTokenRepository->getByUser($this->user));
		Assert::equal(1, $loginToken->getId());
	}


	public function testGetByToken()
	{
		Assert::type(LoginToken::class, $loginToken = $this->loginTokenRepository->getByToken(self::ACTIVE_TOKEN));
		Assert::equal(1, $loginToken->getId());

		Assert::null($this->loginTokenRepository->getByToken(self::EXPIRED_TOKEN));
	}


	public function testCreateLoginToken()
	{
		$now = new DateTime;

		Assert::type(LoginToken::class, $loginToken = $this->loginTokenRepository->createLoginToken($this->user));
		Assert::true($now < $loginToken->getExpiration());
		Assert::type(User::class, $user = $loginToken->getUser());
		Assert::equal(1, $user->getId());
	}


	public function testMapping()
	{
		$loginToken = $this->loginTokenRepository->getByToken(self::ACTIVE_TOKEN);

		Assert::type(User::class, $user = $loginToken->getUser());
		Assert::equal(1, $user->getId());
	}
}

testCase(LoginTokenRepositoryTestCase::class);
