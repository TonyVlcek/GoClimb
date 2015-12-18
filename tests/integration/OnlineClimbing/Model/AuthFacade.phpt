<?php
/**
 * TEST: AuthFacade test
 *
 * @author Tony Vlček
 */

use OnlineClimbing\Model\Entities\Application;
use OnlineClimbing\Model\Entities\LoginToken;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Facades\AuthFacade;
use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class AuthFacadeTestCase extends DatabaseTestCase
{

	const APPLICATION_TOKEN = 'someRandomToken';
	const NOT_EXISTING_APPLICATION_TOKEN = 'I_DO_NOT_EXIST';
	const ACTIVE_TOKEN = 'ACTIVE_TokenString';
	const EXPIRED_TOKEN = 'EXPIRED_TokenString';
	const NOT_ASSIGNED_TOKEN = 'NO_User_Has_This_Token';


	/** @var AuthFacade */
	private $authFacade;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(AuthFacade $authFacade, UserRepository $userRepository)
	{
		parent::__construct();
		$this->authFacade = $authFacade;
		$this->userRepository = $userRepository;
	}


	public function testGetApplicationByToken()
	{
		Assert::null($this->authFacade->getApplicationByToken(self::NOT_EXISTING_APPLICATION_TOKEN));
		Assert::type(Application::class, $app = $this->authFacade->getApplicationByToken(self::APPLICATION_TOKEN));
		Assert::equal(1, $app->getId());
	}


	public function testGetLoginTokenForUser()
	{
		$userWithToken = $this->userRepository->getById(1);
		$userWithoutToken = $this->userRepository->getById(2);

		//returned
		Assert::type(LoginToken::class, $loginToken = $this->authFacade->getLoginTokenForUser($userWithToken));
		Assert::equal(1, $loginToken->getUser()->getId());

		//test expiration
		Assert::true($loginToken->getExpiration() > new DateTime);

		//created
		Assert::type(LoginToken::class, $loginToken = $this->authFacade->getLoginTokenForUser($userWithoutToken));
		Assert::equal(2, $loginToken->getUser()->getId());
	}


	public function testGetUserByToken()
	{
		Assert::null($this->authFacade->getUserByToken(self::EXPIRED_TOKEN));
		Assert::type(User::class, $user = $this->authFacade->getUserByToken(self::ACTIVE_TOKEN));
		Assert::equal(1, $user->getId());

		Assert::null($this->authFacade->getUserByToken(self::NOT_ASSIGNED_TOKEN));
	}
}

testCase(AuthFacadeTestCase::class);
