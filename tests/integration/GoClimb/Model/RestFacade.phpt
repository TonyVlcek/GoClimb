<?php
/**
 * TEST: RestFacade test
 *
 * @author Tony Vlček
 */

use GoClimb\Model\Entities\RestToken;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Facades\RestFacade;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

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

	/** @var  Wall */
	private $wall;

	/** @var  User */
	private $user;


	public function __construct(RestFacade $restFacade, WallRepository $wallRepository, UserRepository $userRepository)
	{
		$this->restFacade = $restFacade;
		$this->wallRepository = $wallRepository;
		$this->userRepository = $userRepository;
	}


	public function setUp()
	{
		$this->wall = $this->wallRepository->getById(1);
		$this->user = $this->userRepository->getById(1);
	}


	public function testValidateToken()
	{
		$wall2 = $this->wallRepository->getById(2);
		$user2 = $this->userRepository->getById(2);

		Assert::true($this->restFacade->validateToken(self::TEST_TOKEN, $this->wall, $this->user, self::TEST_TOKEN_IP));
		Assert::false($this->restFacade->validateToken(self::TEST_TOKEN, $wall2, $this->user, self::TEST_TOKEN_IP));
		Assert::false($this->restFacade->validateToken(self::TEST_TOKEN, $this->wall, $user2, self::TEST_TOKEN_IP));
		Assert::false($this->restFacade->validateToken(self::TEST_TOKEN, $this->wall, $this->user, self::TEST_NEW_TOKEN_IP));

		Assert::false($this->restFacade->validateToken(self::NOT_EXISTING_TOKEN, $this->wall, $this->user, self::TEST_TOKEN_IP));
	}


	public function testGetRestToken()
	{
		$expiredWall = $this->wallRepository->getById(1);
		$expiredUser = $this->userRepository->getById(1);

		//Get existing RestToken
		Assert::type(RestToken::class, $restToken = $this->restFacade->getRestToken($this->wall, $this->user, self::TEST_TOKEN_IP));
		Assert::true($restToken->getExpiration() > new DateTime);
		Assert::equal(1, $restToken->getId());

		//Get newly generated RestToken
		Assert::type(RestToken::class, $restToken = $this->restFacade->getRestToken($this->wall, $this->user, self::TEST_NEW_TOKEN_IP));
		Assert::true($restToken->getExpiration() > new DateTime);
		Assert::equal(self::TEST_NEW_TOKEN_IP, $restToken->getRemoteIp());

		//Create new over token over expired one
		Assert::type(RestToken::class, $restToken = $this->restFacade->getRestToken($expiredWall, $expiredUser, self::EXPIRED_TOKEN_IP));
		Assert::equal(self::EXPIRED_TOKEN_IP, $restToken->getRemoteIp());
	}

}

testCase(RestFacadeTestCase::class);
