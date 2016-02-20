<?php

use GoClimb\Model\Entities\Wall;
use GoClimb\Model\WallException;
use Tester\Assert;

require __DIR__ . '/../../../../bootstrap.php';

$wall = new Wall;

Assert::exception(function () use ($wall) {
	$wall->setBaseUrl('not-a-url');
}, WallException::class);

try {
	$wall->setBaseUrl('http://url.cz');
} catch (WallException $e) {
	Assert::fail('URL which is supposed to be valid is not.');
}
