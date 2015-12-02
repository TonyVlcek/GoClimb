<?php
/**
 * TEST: ApplicationRepository test
 *
 * @author Tony Vlček
 */

use OnlineClimbing\Model\Entities\Application;
use OnlineClimbing\Model\Entities\Wall;
use OnlineClimbing\Model\Repositories\ApplicationRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../bootstrap.php";

class ApplicationRepositoryTestCase extends DatabaseTestCase
{

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
