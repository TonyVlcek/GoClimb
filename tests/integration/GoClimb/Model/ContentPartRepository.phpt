<?php
/**
 * TEST: ContentPartTest test
 *
 * @author Tony Vlček
 */

use GoClimb\Model\Entities\ContentPart;
use GoClimb\Model\Entities\Page;
use GoClimb\Model\Repositories\ContentPartRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class ContentPartRepositoryTestCase extends DatabaseTestCase
{

	/** @var ContentPartRepository */
	private $contentPartRepository;


	public function __construct(ContentPartRepository $contentPartRepository)
	{
		$this->contentPartRepository = $contentPartRepository;
	}


	public function testGetById()
	{
		Assert::null($this->contentPartRepository->getById(0));
		Assert::type(ContentPart::class, $cp = $this->contentPartRepository->getById(1));
		Assert::equal(1, $cp->getId());
	}


	public function testMapping()
	{
		$cp = $this->contentPartRepository->getById(1);

		Assert::type(Page::class, $page = $cp->getPage());
		Assert::equal(1, $page->getId());
	}
}

testCase(ContentPartRepositoryTestCase::class);
