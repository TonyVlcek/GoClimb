<?php
/**
 * TEST: BaseRepository mapping test.
 *
 * @author Tomáš Blatný
 */

namespace Bar;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\EntityManager;
use Nette\DI\Container;
use OnlineClimbing\Model\Repositories\BaseRepository;
use Tester\Assert;


/** @var Container $container */
$container = require __DIR__ . '/../../../bootstrap.php';

/**
 * @ORM\Entity
 */
class Foo
{

}

class FooRepository extends BaseRepository
{

	protected $entityNamespace = '\\Bar\\';


	public function testMapping()
	{
		Assert::equal('\\' . strtolower(Foo::class), strtolower($this->getEntityClass()));
	}

}

/** @var EntityManager $entityManager */
$entityManager = $container->getByType(EntityManager::class);

$fooRepository = new FooRepository($entityManager);
$fooRepository->testMapping();
