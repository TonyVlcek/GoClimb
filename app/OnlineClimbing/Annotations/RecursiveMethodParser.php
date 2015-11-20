<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Annotations;

use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Reflection\Method;


class RecursiveMethodParser
{

	/** @var Cache */
	private $cache;


	/**
	 * @param IStorage $storage
	 */
	public function __construct(IStorage $storage)
	{
		$this->cache = new Cache($storage, 'OnlineClimbing.Annotations.RecursiveMethodAnnotationsParser');
	}


	/**
	 * @param Method $reflection
	 * @return array
	 */
	public function parse(Method $reflection)
	{
		return $this->cache->load($reflection->getDeclaringClass()->getName() . '::' . $reflection->getName(), function (&$dependencies) use ($reflection) {
			return $this->getAnnotations($reflection, $dependencies);
		});
	}


	/**
	 * @param Method $reflection
	 * @param array $dependencies
	 * @return array
	 */
	private function getAnnotations(Method $reflection, &$dependencies = [])
	{
		$annotations = $reflection->getAnnotations();
		$dependencies[Cache::FILES][] = $reflection->getFileName();
		$parent = $reflection->getDeclaringClass();
		while ($parent = $parent->getParentClass()) {
			$dependencies[Cache::FILES][] = $parent->getFileName();
			if ($parent->hasMethod($reflection->getName())) {
				$annotations = array_merge_recursive($parent->getMethod($reflection->getName())->getAnnotations(), $annotations);
			}
		}
		return $annotations;
	}

}
