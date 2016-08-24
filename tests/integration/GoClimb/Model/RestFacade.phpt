<?php
/**
 * Test: RestFacade test
 */

use GoClimb\Model\Entities\RestToken;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Facades\RestFacade;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Nette\Utils\DateTime;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class RestFacadeTestCase extends DatabaseTestCase
{

	const TEST_TOKEN = 'testtokennumberone';
	const NOT_EXISTING_TOKEN = 'I_DO_NOT_EXIST';
	const TEST_TOKEN_IP = '192.168.10.1';
	const TEST_NEW_TOKEN_IP = '1.1.1.1';
	const EXPIRED_TOKEN_IP = '192.168.10.2';

	/** @var RestFacade */
	private $restFacade;

	/** @var WallRepository */
	private $wallRepository;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(RestFacade $restFacade, WallRepository $wallRepository, UserRepository $userRepository)
	{
		parent::__construct();
		$this->restFacade = $restFacade;
		$this->wallRepository = $wallRepository;
		$this->userRepository = $userRepository;
	}


	public function testValidateToken()
	{
		list($wall, $wall2, $user, $user2) = $this->getEntities();
		Assert::true($this->validateToken(self::TEST_TOKEN, $wall, $user, self::TEST_TOKEN_IP));
		Assert::false($this->validateToken(self::TEST_TOKEN, $wall2, $user, self::TEST_TOKEN_IP));
		Assert::false($this->validateToken(self::TEST_TOKEN, $wall, $user2, self::TEST_TOKEN_IP));
		Assert::false($this->validateToken(self::TEST_TOKEN, $wall, $user, self::TEST_NEW_TOKEN_IP));

		Assert::null($this->restFacade->getRestToken(self::NOT_EXISTING_TOKEN, FALSE));
	}


	public function testGetOrGenerateRestToken()
	{
		list($wall, $expiredWall, $user, $expiredUser) = $this->getEntities();

		//Get existing RestToken
		Assert::type(RestToken::class, $restToken = $this->restFacade->getOrGenerateRestToken($wall, $user, self::TEST_TOKEN_IP));
		Assert::true($restToken->getExpiration() > new DateTime);
		Assert::equal(self::TEST_TOKEN, $restToken->getToken());

		//Get newly generated RestToken
		Assert::type(RestToken::class, $restToken = $this->restFacade->getOrGenerateRestToken($wall, $user, self::TEST_NEW_TOKEN_IP));
		Assert::true($restToken->getExpiration() > new DateTime);
		Assert::equal(self::TEST_NEW_TOKEN_IP, $restToken->getRemoteIp());

		//Create new token over expired one
		Assert::type(RestToken::class, $restToken = $this->restFacade->getOrGenerateRestToken($expiredWall, $expiredUser, self::EXPIRED_TOKEN_IP));
		Assert::equal(self::EXPIRED_TOKEN_IP, $restToken->getRemoteIp());
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		$fixtures = [
			$wallOne = (new Wall)->setName('Wall One'),
			$wallTwo = (new Wall)->setName('Wall Two'),
			$userOne = (new User)->setEmail('aa@aa.aa')->setPassword('aaa'),
			$userTwo = (new User)->setEmail('bb@bb.bb')->setPassword('bbb'),
			$restTokenOne = (new RestToken)->setUser($userOne)->setWall($wallOne)->setToken(self::TEST_TOKEN)->setRemoteIp(self::TEST_TOKEN_IP)->setExpiration(new DateTime('+1 day')),
			$restTokenTwo = (new RestToken)->setUser($userTwo)->setWall($wallTwo)->setToken('ExpiredToken')->setRemoteIp(self::EXPIRED_TOKEN_IP)->setExpiration(new DateTime('-1 day')),
		];

		$wallOne->addRestToken($restTokenOne);
		$wallTwo->addRestToken($restTokenTwo);
		$userOne->addRestToken($restTokenOne);
		$userTwo->addRestToken($restTokenTwo);

		return $fixtures;
	}


	private function validateToken($token, Wall $wall, User $user, $ip)
	{
		$restToken = $this->restFacade->getRestToken($token, FALSE);
		return $restToken->getUser() === $user && $restToken->getWall() === $wall && $restToken->getRemoteIp() === $ip;
	}


	private function getEntities()
	{
		return [
			$this->wallRepository->getByName('Wall One'),
			$this->wallRepository->getByName('Wall Two'),
			$this->userRepository->getByEmail('aa@aa.aa'),
			$this->userRepository->getByEmail('bb@bb.bb'),
		];
	}
}

testCase(RestFacadeTestCase::class);
