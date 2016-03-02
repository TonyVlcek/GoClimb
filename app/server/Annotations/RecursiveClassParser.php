<?php

namespace GoClimb\Annotations;

use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Reflection\ClassType;


class RecursiveClassParser
{

	/** @var Cache */
	private $cache;


	/**
	 * @param IStorage $storage
	 */
	public function __construct(IStorage $storage)
	{
		$this->cache = new Cache($storage, 'GoClimb.Annotations.RecursiveClassAnnotationsParser');
	}


	/**
	 * @param ClassType $reflection
	 * @return array
	 */
	public function parse(ClassType $reflection)
	{
		return $this->cache->load($reflection->getName(), function (&$dependencies) use ($reflection) {
			return $this->getAnnotations($reflection, $dependencies);
		});
	}


	/**
	 * @param ClassType $reflection
	 * @param array $dependencies
	 * @return array
	 */
	private function getAnnotations(ClassType $reflection, &$dependencies = [])
	{
		$annotations = $reflection->getAnnotations();
		$dependencies[Cache::FILES][] = $reflection->getFileName();
		if ($parent = $reflection->getParentClass()) {
			$annotations = array_merge_recursive($this->getAnnotations($parent), $annotations);
		}
		return $annotations;
	}

}
