<?php
/**
 * Test: RestTokenRepository test
 */

use GoClimb\Model\Entities\RestToken;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\RestTokenRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Nette\Utils\DateTime;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class RestTokenRepositoryTestCase extends DatabaseTestCase
{

	const TEST_TOKEN = 'Token';
	const TEST_TOKEN_IP = '192.168.10.1';

	/** @var RestTokenRepository */
	private $restTokenRepository;

	/** @var WallRepository */
	private $wallRepository;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(RestTokenRepository $restTokenRepository, WallRepository $wallRepository, UserRepository $userRepository)
	{
		parent::__construct();

		$this->restTokenRepository = $restTokenRepository;
		$this->wallRepository = $wallRepository;
		$this->userRepository = $userRepository;
	}


	public function testGetByToken()
	{
		Assert::type(RestToken::class, $restToken = $this->restTokenRepository->getByToken(self::TEST_TOKEN));
		Assert::equal(self::TEST_TOKEN, $restToken->getToken());
	}


	public function testGetRestTokenByUser()
	{
		list($wall, $user, $invalidWall, $invalidUser) = $this->getEntities();

		Assert::null($this->restTokenRepository->getRestTokenByUser($wall, $invalidUser, self::TEST_TOKEN_IP));
		Assert::null($this->restTokenRepository->getRestTokenByUser($invalidWall, $user, self::TEST_TOKEN_IP));
		Assert::null($this->restTokenRepository->getRestTokenByUser($invalidWall, $invalidUser, self::TEST_TOKEN_IP));

		Assert::type(RestToken::class, $restToken = $this->restTokenRepository->getRestTokenByUser($wall, $user, self::TEST_TOKEN_IP));
		Assert::equal(self::TEST_TOKEN, $restToken->getToken());
	}


	public function testMapping()
	{
		list($wall, $user) = $this->getEntities();

		$restToken = $this->restTokenRepository->getRestTokenByUser($wall, $user, self::TEST_TOKEN_IP);

		Assert::type(User::class, $user = $restToken->getUser());
		Assert::equal('aa@aa.aa', $user->getEmail());

		Assert::type(Wall::class, $wall = $restToken->getWall());
		Assert::equal('Wall One', $wall->getName());
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		$fixtures = [
			$wall = (new Wall)->setName('Wall One'),
			$user = (new User)->setEmail('aa@aa.aa')->setPassword('aaa'),
			(new Wall)->setName('Wall Two'),
			(new User)->setEmail('bb@bb.bb')->setPassword('bbb'),
			$restToken = (new RestToken)->setUser($user)->setWall($wall)->setToken(self::TEST_TOKEN)->setRemoteIp(self::TEST_TOKEN_IP)->setExpiration(new DateTime('+1 day')),
		];
		$wall->addRestToken($restToken);
		$user->addRestToken($restToken);

		return $fixtures;
	}


	private function getEntities()
	{
		return [
			$this->wallRepository->getByName('Wall One'),
			$this->userRepository->getByEmail('aa@aa.aa'),
			$this->wallRepository->getByName('Wall Two'),
			$this->userRepository->getByEmail('bb@bb.bb'),
		];
	}
}

testCase(RestTokenRepositoryTestCase::class);
