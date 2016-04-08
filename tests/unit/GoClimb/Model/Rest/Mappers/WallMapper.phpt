<?php

use GoClimb\Model\Entities\Language;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Entities\WallLanguage;
use GoClimb\Model\Entities\WallTranslation;
use GoClimb\Model\Rest\Mappers\WallMapper;
use Tester\Assert;

require __DIR__ . '/../../../../../bootstrap.php';

$wall = new Wall;
$language = new Language;
$wallLanguage = new WallLanguage;
$wallTranslation = new WallTranslation;

$data = [
	'name' => 'TestWall',
	'description' => [
		'en' => 'Description',
	],
	'street' => 'TestStreet',
	'number' => '99t',
	'country' => 'The United States of Tests',
	'zip' => '99T 00',
];

$wallTranslation->setDescription($data['description']['en']);
$language->setShortcut('en');

$wallLanguage->setLanguage($language);
$wallLanguage->setWallTranslation($wallTranslation);
$wallLanguage->setWall($wall);

foreach ($data as $field => $value) {
	if ($field !== 'description') {
		$method = 'set' . ucfirst($field);
		$wall->$method($value);
	}
}

$wall->addWallLanguage($wallLanguage);

Assert::type('array', $serialized = WallMapper::mapDetails($wall));
Assert::equal($data, $serialized);
