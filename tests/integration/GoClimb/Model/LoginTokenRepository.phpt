<?php
/**
 * Test: LoginTokenRepository test
 */

use GoClimb\Model\Entities\LoginToken;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Repositories\LoginTokenRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Nette\Utils\DateTime;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class LoginTokenRepositoryTestCase extends DatabaseTestCase
{

	const NOT_EXISTING_TOKEN = 'I_DO_NOT_EXIST';
	const ACTIVE_TOKEN = 'ACTIVE_TokenString';
	const EXPIRED_TOKEN = 'EXPIRED_TokenString';

	/** @var LoginTokenRepository */
	private $loginTokenRepository;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(LoginTokenRepository $loginTokenRepository, UserRepository $userRepository)
	{
		parent::__construct();
		$this->loginTokenRepository = $loginTokenRepository;
		$this->userRepository = $userRepository;
	}


	public function testGetByUser()
	{
		list($user, $userExpiredToken, $userWithoutToken) = $this->getEntities();
		Assert::null($this->loginTokenRepository->getByUser($userWithoutToken));
		Assert::null($this->loginTokenRepository->getByUser($userExpiredToken));
		Assert::type(LoginToken::class, $loginToken = $this->loginTokenRepository->getByUser($user));
		Assert::equal(self::ACTIVE_TOKEN, $loginToken->getToken());
	}


	public function testGetByToken()
	{
		Assert::null($this->loginTokenRepository->getByToken(self::NOT_EXISTING_TOKEN));
		Assert::type(LoginToken::class, $loginToken = $this->loginTokenRepository->getByToken(self::ACTIVE_TOKEN));
		Assert::equal(self::ACTIVE_TOKEN, $loginToken->getToken());

		Assert::null($this->loginTokenRepository->getByToken(self::EXPIRED_TOKEN));
	}


	public function testCreateLoginToken()
	{
		$now = new DateTime;
		list($user) = $this->getEntities();

		Assert::type(LoginToken::class, $loginToken = $this->loginTokenRepository->createLoginToken($user, TRUE));
		Assert::true($now < $loginToken->getExpiration());
		Assert::type(User::class, $user = $loginToken->getUser());
		Assert::equal('aa@aa.aa', $user->getEmail());
	}


	public function testMapping()
	{
		$loginToken = $this->loginTokenRepository->getByToken(self::ACTIVE_TOKEN);

		Assert::type(User::class, $user = $loginToken->getUser());
		Assert::equal('aa@aa.aa', $user->getEmail());
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		$fixtures =  [
			$userActiveToken = (new User)->setEmail('aa@aa.aa')->setPassword('aaa'),
			$userExpiredToken = (new User)->setEmail('bb@bb.bb')->setPassword('bbb'),
			(new User)->setEmail('cc@cc.cc')->setPassword('ccc'),
			$activeToken = (new LoginToken)->setToken(self::ACTIVE_TOKEN)->setUser($userActiveToken)->setExpiration((new DateTime)->modify('+1 day'))->setLongTerm(0),
			$expiredToken = (new LoginToken)->setToken(self::EXPIRED_TOKEN)->setUser($userExpiredToken)->setExpiration((new DateTime)->modify('-1 day'))->setLongTerm(0),
		];
		$userActiveToken->addLoginToken($activeToken);
		$userExpiredToken->addLoginToken($expiredToken);

		return $fixtures;
	}


	private function getEntities()
	{
		return [
			$this->userRepository->getByEmail('aa@aa.aa'),
			$this->userRepository->getByEmail('bb@bb.bb'),
			$this->userRepository->getByEmail('cc@cc.cc'),
		];
	}
}

testCase(LoginTokenRepositoryTestCase::class);
