<?php

use GoClimb\Model\Entities\WallLanguage;
use GoClimb\Model\WallLanguageException;
use Tester\Assert;

require __DIR__ . '/../../../../bootstrap.php';

$wall = new WallLanguage;

Assert::exception(function () use ($wall) {
	$wall->setUrl('not-a-url');
}, WallLanguageException::class);

try {
	$wall->setUrl('http://url.cz');
} catch (WallLanguageException $e) {
	Assert::fail('URL which is supposed to be valid is not.');
}
