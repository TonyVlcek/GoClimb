<?php

use OnlineClimbing\Model\Entities\User;
use Tester\Assert;

require __DIR__ . '/../../../../bootstrap.php';

$user = new User;
$user->setFirstName('Martin')->setLastName('Mikšík');

Assert::equal('Martin Mikšík', $user->getFullName());
