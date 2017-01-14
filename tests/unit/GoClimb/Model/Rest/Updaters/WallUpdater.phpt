<?php

use GoClimb\Model\Entities\Language;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Entities\WallLanguage;
use GoClimb\Model\Entities\WallTranslation;
use GoClimb\Model\Rest\Updaters\WallUpdater;
use Nette\DI\Container;
use Tester\Assert;

/** @var Container $container */
$container = require __DIR__ . '/../../../../../bootstrap.php';

/** @var WallUpdater $wallUpdater */
$wallUpdater = $container->getByType(WallUpdater::class);

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
	'analyticsCode' => 'UA-XXXX-XX',
];

$wallTranslation->setDescription($data['description']['en']);
$language->setShortcut('en');
$language->setName('English');
$language->setConst('english');

$wallLanguage->setWall($wall);
$wallLanguage->setWallTranslation($wallTranslation);
$wallLanguage->setLanguage($language);
$wallLanguage->setUrl('http://this.is.url/');

$wall->addWallLanguage($wallLanguage);

$dataClass = new stdClass;
foreach ($data as $field => $value) {
	$dataClass->$field = $value;
}


Assert::type(Wall::class, $unserialized = $wallUpdater->updateDetails($wall, $dataClass));
foreach ($data as $field => $value) {
	if ($field === "description") {
		Assert::equal($unserialized->getDescription('en'), $value['en']);
	} else {
		$method = ($field !== 'published' ? 'get' : 'is') . ucfirst($field);
		Assert::equal($unserialized->$method(), $value);
	}
}
