<?php
/**
 * Test: ApplicationRepository test
 */

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\ApplicationRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class ApplicationRepositoryTestCase extends DatabaseTestCase
{

	const NOT_EXISTING_TOKEN = ApplicationRepository::class . 'NotExisting';
	const TOKEN = ApplicationRepository::class . 'Token';
	const APP_NAME = ApplicationRepository::class . 'App';
	const WALL_NAME = ApplicationRepository::class . 'Wall';

	/** @var ApplicationRepository */
	private $applicationRepository;


	public function __construct(ApplicationRepository $applicationRepository)
	{
		parent::__construct();
		$this->applicationRepository = $applicationRepository;
	}


	public function testGetByToken()
	{
		Assert::null($this->applicationRepository->getByToken(self::NOT_EXISTING_TOKEN));
		Assert::type(Application::class, $app = $this->applicationRepository->getByToken(self::TOKEN));
		Assert::equal(self::APP_NAME, $app->getName());
	}


	public function testMapping()
	{
		$app = $this->applicationRepository->getByToken(self::TOKEN);

		Assert::type(Wall::class, $wall = $app->getWall());
		Assert::equal(self::WALL_NAME, $wall->getName());
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		$fixtures = [];
		$fixtures[] = $wall = (new Wall)->setName(self::WALL_NAME);
		$fixtures[] = $app = (new Application)->setName(self::APP_NAME)->setDescription('Description')->setToken(self::TOKEN)->setWall($wall);
		$wall->setApplication($app);

		return $fixtures;
	}
}

testCase(ApplicationRepositoryTestCase::class);
