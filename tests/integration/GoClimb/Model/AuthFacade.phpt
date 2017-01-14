<?php
/**
 * Test: AuthFacade test
 */

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Entities\LoginToken;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Facades\AuthFacade;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Nette\Utils\DateTime;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class AuthFacadeTestCase extends DatabaseTestCase
{

	const APPLICATION_TOKEN = 'someRandomToken';
	const NOT_EXISTING_APPLICATION_TOKEN = 'I_DO_NOT_EXIST';
	const ACTIVE_TOKEN = 'ACTIVE_TokenString';
	const EXPIRED_TOKEN = 'EXPIRED_TokenString';
	const NOT_ASSIGNED_TOKEN = 'NO_User_Has_This_Token';
	const REDIRECT_TOKEN = 'REDIRECT_TOKEN_STRING';


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
		Assert::type(LoginToken::class, $loginToken = $this->authFacade->getLoginTokenForUser($userWithToken, TRUE));
		Assert::equal(1, $loginToken->getUser()->getId());

		//test expiration
		Assert::true($loginToken->getExpiration() > new DateTime);

		//created
		Assert::type(LoginToken::class, $loginToken = $this->authFacade->getLoginTokenForUser($userWithoutToken, TRUE));
		Assert::equal(2, $loginToken->getUser()->getId());
	}


	public function testGetRedirectTokenForUser()
	{
		$userWithToken = $this->userRepository->getById(3);

		//returned
		Assert::type(LoginToken::class, $loginToken = $this->authFacade->getRedirectTokenForUser($userWithToken));
		Assert::equal(3, $loginToken->getUser()->getId());

		//test expiration
		Assert::true($loginToken->getExpiration() > DateTime::from('+58 minute'));
		Assert::true($loginToken->getExpiration() < DateTime::from('+62 minute'));

	}


	public function testGetUserByToken()
	{
		Assert::null($this->authFacade->getUserByToken(self::EXPIRED_TOKEN));
		Assert::type(User::class, $user = $this->authFacade->getUserByToken(self::ACTIVE_TOKEN));
		Assert::equal(1, $user->getId());

		Assert::null($this->authFacade->getUserByToken(self::NOT_ASSIGNED_TOKEN));
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		return [
			$userOne = (new User)->setEmail('aa@aa.aa')->setPassword('aaa'),
			$userTwo = (new User)->setEmail('bb@bb.bb')->setPassword('bbb'),
			$userThree = (new User)->setEmail('cc@cc.cc')->setPassword('ccc'),
			(new Application)->setName('App')->setDescription('desc')->setToken(self::APPLICATION_TOKEN),
			(new LoginToken)->setUser($userOne)->setToken(self::EXPIRED_TOKEN)->setExpiration(new DateTime('-1 day'))->setLongTerm(0),
			(new LoginToken)->setUser($userOne)->setToken(self::ACTIVE_TOKEN)->setExpiration(new DateTime('+1 day'))->setLongTerm(0),
			(new LoginToken)->setUser($userThree)->setToken(self::REDIRECT_TOKEN)->setExpiration(new DateTime('+1 hour'))->setLongTerm(0)
		];
	}
}

testCase(AuthFacadeTestCase::class);
