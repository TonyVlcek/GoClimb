<?php

use OnlineClimbing\Model\Entities\User;
use Tester\Assert;

require __DIR__ . '/../../../../bootstrap.php';

$user = new User;

$user->setFirstName('Martin')->setLastName('Mikšík');
Assert::equal('Martin Mikšík', $user->getFullName());

Assert::null($user->getAge());
$user->setBirthDate((new DateTime)->modify('-10 years'));
Assert::equal(10, $user->getAge()->y);
