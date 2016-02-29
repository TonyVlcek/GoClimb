<?php
/**
 * Test: ApplicationRepository test
 */

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\ApplicationRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class ApplicationRepositoryTestCase extends DatabaseTestCase
{

	const NOT_EXISTING_TOKEN = 'ThisTokenDoesNotExist';
	const TOKEN = 'someRandomToken';

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
		Assert::equal(1, $app->getId());
	}


	public function testMapping()
	{
		$app = $this->applicationRepository->getByToken(self::TOKEN);

		Assert::type(Wall::class, $wall = $app->getWall());
		Assert::equal(1, $wall->getId());
	}
}

testCase(ApplicationRepositoryTestCase::class);
