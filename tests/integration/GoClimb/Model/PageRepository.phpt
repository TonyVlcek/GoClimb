<?php
/**
 * Test: PageRepository test
 */

use GoClimb\Model\Entities\ContentPart;
use GoClimb\Model\Entities\Page;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\PageRepository;
use GoClimb\Tests\Helpers;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

class PageRepositoryTestCase extends DatabaseTestCase
{

	/** @var PageRepository */
	private $pageRepository;


	public function __construct(PageRepository $pageRepository)
	{
		parent::__construct();
		$this->pageRepository = $pageRepository;
	}


	public function testGetById()
	{
		Assert::null($this->pageRepository->getById(0));
		Assert::type(Page::class, $page = $this->pageRepository->getById(1));
		Assert::equal(1, $page->getId());
	}


	public function testMapping()
	{
		$page = $this->pageRepository->getById(1);

		Assert::type(Wall::class, $wall = $page->getWall());
		Assert::equal(1, $wall->getId());

		Helpers::assertTypeRecursive(ContentPart::class, $cps = $page->getContentParts());
		Assert::equal([1], Helpers::mapIds($cps));
	}

}

testCase(PageRepositoryTestCase::class);
