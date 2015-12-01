<?php
/**
 * TEST: ImageRepository test
 *
 * @author Martin Mikšík
 */

use OnlineClimbing\Model\Entities\ContentPart;
use OnlineClimbing\Model\Entities\File;
use OnlineClimbing\Model\Repositories\ImageRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . '/../../bootstrap.php';

class ImageRepositoryTestCase extends DatabaseTestCase
{

	/** @var ImageRepository $imageRepository */
	private $imageRepository;


	public function __construct(ImageRepository $imageRepository)
	{
		parent::__construct();
		$this->imageRepository = $imageRepository;
	}


	public function testMapping()
	{
		$image = $this->imageRepository->getById(1);

		Assert::type(File::class, $file = $image->getFile());
		Assert::equal(1, $file->getId());

		Assert::type(File::class, $thumbnailFile = $image->getThumbnailFile());
		Assert::equal(1, $thumbnailFile->getId());

		Assert::type(ContentPart::class, $contentPart = $image->getContentPart());
		Assert::equal(1, $contentPart->getId());

		Assert::equal(1920, $image->getWidth());
		Assert::equal(1080, $image->getHeight());
	}

}

testCase(ImageRepositoryTestCase::class);
