<?php
/**
 * TEST: RestTokenRepository test
 *
 * @author Tony Vlček
 */

use GoClimb\Model\Entities\RestToken;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\RestTokenRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class RestTokenRepositoryTestCase extends DatabaseTestCase
{

	const TEST_TOKEN_IP = '192.168.10.1';

	/** @var RestTokenRepository */
	private $restTokenRepository;

	/** @var WallRepository */
	private $wallRepository;

	/** @var UserRepository */
	private $userRepository;

	/** @var Wall */
	private $wall;

	/** @var User */
	private $user;

	/** @var Wall */
	private $invalidWall;

	/** @var User */
	private $invalidUser;


	public function __construct(RestTokenRepository $restTokenRepository, WallRepository $wallRepository, UserRepository $userRepository)
	{
		parent::__construct();

		$this->restTokenRepository = $restTokenRepository;
		$this->wallRepository = $wallRepository;
		$this->userRepository = $userRepository;
	}


	public function setUp()
	{
		$this->wall = $this->wallRepository->getById(1);
		$this->user = $this->userRepository->getById(1);

		$this->invalidWall = $this->wallRepository->getById(3);
		$this->invalidUser = $this->userRepository->getById(4);
	}


	public function testGetRestToken()
	{
		Assert::null($this->restTokenRepository->getRestToken($this->wall, $this->invalidUser, self::TEST_TOKEN_IP));
		Assert::null($this->restTokenRepository->getRestToken($this->invalidWall, $this->user, self::TEST_TOKEN_IP));
		Assert::null($this->restTokenRepository->getRestToken($this->invalidWall, $this->invalidUser, self::TEST_TOKEN_IP));

		Assert::type(RestToken::class, $restToken = $this->restTokenRepository->getRestToken($this->wall, $this->user, self::TEST_TOKEN_IP));
		Assert::equal(1, $restToken->getId());
	}


	public function testMapping()
	{
		$restToken = $this->restTokenRepository->getRestToken($this->wall, $this->user, self::TEST_TOKEN_IP);

		Assert::type(User::class, $user = $restToken->getUser());
		Assert::equal(1, $user->getId());

		Assert::type(Wall::class, $wall = $restToken->getWall());
		Assert::equal(1, $wall->getId());
	}

}

testCase(RestTokenRepositoryTestCase::class);
