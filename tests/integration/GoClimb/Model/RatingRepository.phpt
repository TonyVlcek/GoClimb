<?php
/**
 * Test: RatingRepository test
 */

use GoClimb\Model\Entities\Difficulty;
use GoClimb\Model\Entities\Line;
use GoClimb\Model\Entities\Rating;
use GoClimb\Model\Entities\Rope;
use GoClimb\Model\Entities\Route;
use GoClimb\Model\Entities\Sector;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\RatingRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class RatingRepositoryTestCase extends DatabaseTestCase
{

	/** @var RatingRepository */
	private $ratingRepository;


	public function __construct(RatingRepository $ratingRepository)
	{
		parent::__construct();
		$this->ratingRepository = $ratingRepository;
	}


	public function testGetById()
	{
		Assert::null($this->ratingRepository->getById(0));
		Assert::type(Rating::class, $rating = $this->ratingRepository->getById(1));
		Assert::equal(1, $rating->getId());
	}


	public function testMapping()
	{
		$rating = $this->ratingRepository->getById(1);

		Assert::type(Route::class, $route = $rating->getRoute());
		Assert::equal(1, $route->getId());

		Assert::type(User::class, $user = $rating->getAuthor());
		Assert::equal(2, $user->getId());
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		$fixtures = [
			$wall = (new Wall)->setName('WallRating'),
			$sector = (new Sector)->setName('SectorRating')->setWall($wall),
			$builder = (new User)->setEmail('builder@builder.builder')->setPassword('builder'),
			$line = (new Line)->setName('line')->setSector($sector),
			$difficulty = (new Difficulty)->setPoints(55),
			$user = (new User)->setEmail('bb@bb.bb')->setPassword('bb'),
			$route = (new Rope)->setName('Rope')->setLine($line)->setBuilder($builder)->setDifficulty($difficulty),
			$rating = (new Rating)->setAuthor($user)->setRoute($route)->setNote('note')->setRating(1)->setCreatedDate(new DateTime('now')),
		];

		return $fixtures;
	}
}

testCase(RatingRepositoryTestCase::class);
