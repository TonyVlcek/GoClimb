<?php
/**
 * TEST: LoginTokenRepository test
 *
 * @author Tony Vlček
 */

use GoClimb\Model\Entities\LoginToken;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Repositories\LoginTokenRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Nette\Utils\DateTime;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class LoginTokenRepositoryTestCase extends DatabaseTestCase
{

	const NOT_EXISTING_TOKEN = 'I_DO_NOT_EXIST';
	const ACTIVE_TOKEN = 'ACTIVE_TokenString';
	const EXPIRED_TOKEN = 'EXPIRED_TokenString';

	/** @var LoginTokenRepository */
	private $loginTokenRepository;

	/** @var UserRepository */
	private $userRepository;

	/** @var  User */
	private $user;

	/** @var  User */
	private $userWithoutToken;

	/** @var  User */
	private $userExpiredToken;


	public function __construct(LoginTokenRepository $loginTokenRepository, UserRepository $userRepository)
	{
		$this->loginTokenRepository = $loginTokenRepository;
		$this->userRepository = $userRepository;

		$this->user = $this->userRepository->getById(1);
		$this->userWithoutToken = $this->userRepository->getById(3);
		$this->userExpiredToken = $this->userRepository->getById(2);
	}


	public function testGetByUser()
	{
		Assert::null($this->loginTokenRepository->getByUser($this->userWithoutToken));
		Assert::null($this->loginTokenRepository->getByUser($this->userExpiredToken));
		Assert::type(LoginToken::class, $loginToken = $this->loginTokenRepository->getByUser($this->user));
		Assert::equal(1, $loginToken->getId());
	}


	public function testGetByToken()
	{
		Assert::null($this->loginTokenRepository->getByToken(self::NOT_EXISTING_TOKEN));
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
