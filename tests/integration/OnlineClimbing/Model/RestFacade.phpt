<?php
/**
 * TEST: RestFacade test
 *
 * @author Tony Vlček
 */

use OnlineClimbing\Model\Entities\RestToken;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Entities\Wall;
use OnlineClimbing\Model\Facades\RestFacade;
use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\Model\Repositories\WallRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class RestFacadeTestCase extends DatabaseTestCase
{

	const TEST_TOKEN = 'testtokennumberone';
	const TEST_TOKEN_IP = '192.168.10.1';
	const TEST_NEW_TOKEN_IP = '1.1.1.1';

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
		parent::__construct();
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
		Assert::true($this->restFacade->validateToken(self::TEST_TOKEN, $this->wall, $this->user, self::TEST_TOKEN_IP));
		Assert::false($this->restFacade->validateToken(self::TEST_TOKEN, $this->wall, $this->user, self::TEST_NEW_TOKEN_IP));
	}


	public function testGetRestToken()
	{
		//Get existing RestToken
		Assert::type(RestToken::class, $restToken = $this->restFacade->getRestToken($this->wall, $this->user, self::TEST_TOKEN_IP));
		Assert::equal(1, $restToken->getId());

		//Get newly generated RestToken
		Assert::type(RestToken::class, $restToken = $this->restFacade->getRestToken($this->wall, $this->user, self::TEST_NEW_TOKEN_IP));
		Assert::equal(self::TEST_NEW_TOKEN_IP, $restToken->getRemoteIp());
	}

}

testCase(RestFacadeTestCase::class);
