<?php
/**
 * TEST: ContentPartTest test
 *
 * @author Tony Vlček
 */

use OnlineClimbing\Model\Entities\ContentPart;
use OnlineClimbing\Model\Entities\Page;
use OnlineClimbing\Model\Repositories\ContentPartRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

class ContentPartRepositoryTestCase extends DatabaseTestCase
{

	/** @var ContentPartRepository */
	private $contentPartRepository;


	public function __construct(ContentPartRepository $contentPartRepository)
	{
		parent::__construct();
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
