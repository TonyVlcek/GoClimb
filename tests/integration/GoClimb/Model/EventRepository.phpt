<?php
/**
 * Test: EventRepository test
 */

use GoClimb\Model\Entities\Event;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\EventRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Nette\Utils\DateTime;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class EventRepositoryTestCase extends DatabaseTestCase
{

	/** @var EventRepository */
	private $eventRepository;

	/** @var WallRepository */
	private $wallRepository;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(EventRepository $eventRepository, WallRepository $wallRepository, UserRepository $userRepository)
	{
		parent::__construct();
		$this->eventRepository = $eventRepository;
		$this->wallRepository = $wallRepository;
		$this->userRepository = $userRepository;
	}


	public function testGetById()
	{
		Assert::null($this->eventRepository->getById(0));
		Assert::type(Event::class, $event = $this->eventRepository->getById(1));
		Assert::equal(1, $event->getId());
	}


	public function testGetByWall()
	{
		Assert::equal([1], Helpers::mapIds($this->eventRepository->getByWall($this->wallRepository->getById(1), TRUE)));
		Assert::equal([2, 4], Helpers::mapIds($this->eventRepository->getByWall($this->wallRepository->getById(2), NULL)));
		Assert::equal([4], Helpers::mapIds($this->eventRepository->getByWall($this->wallRepository->getById(2), FALSE)));
	}


	public function testGetGlobal()
	{
		Assert::equal([5], Helpers::mapIds($this->eventRepository->getGlobal(TRUE)));
		Assert::equal([5, 6], Helpers::mapIds($this->eventRepository->getGlobal(NULL)));
		Assert::equal([6], Helpers::mapIds($this->eventRepository->getGlobal(FALSE)));
	}


	public function testMapping()
	{
		$event = $this->eventRepository->getById(1);

		Assert::type(User::class, $event->getAuthor());
		Assert::equal(1, $event->getAuthor()->getId());

		Assert::type(Wall::class, $event->getWall());
		Assert::equal(1, $event->getWall()->getId());
	}


	/**
	 * @return array
	 */
	protected function getFixtures()
	{
		return [
			$wallOne = (new Wall)->setName('one'),
			$wallTwo = (new Wall)->setName('two'),
			$author = (new User)->setEmail('aa@aa.aa')->setPassword('aaa'),
			(new Event)->setName('Event one')->setWall($wallOne)->setPublishedDate(new DateTime('-7 days'))->setAuthor($author)->setContent('Content'),
			(new Event)->setName('Event two')->setWall($wallTwo)->setPublishedDate(new DateTime('-7 days'))->setContent('Content'),
			(new Event)->setName('Event three')->setWall($wallOne)->setContent('Content'),
			(new Event)->setName('Event four')->setWall($wallTwo)->setContent('Content'),
			(new Event)->setName('Event five')->setPublishedDate(new DateTime('-7 days'))->setContent('Content'),
			(new Event)->setName('Event six')->setContent('Content'),
		];
	}
}

testCase(EventRepositoryTestCase::class);
