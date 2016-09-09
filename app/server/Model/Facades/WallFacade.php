<?php

namespace GoClimb\Model\Facades;

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Entities\Language;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Entities\WallLanguage;
use GoClimb\Model\Entities\WallTranslation;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Repositories\WallRepository;


class WallFacade
{

	/** @var WallRepository */
	private $wallRepository;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(WallRepository $wallRepository, UserRepository $userRepository)
	{
		$this->wallRepository = $wallRepository;
		$this->userRepository = $userRepository;
	}


	/**
	 * @return Wall[]
	 */
	public function getAllWalls()
	{
		return $this->wallRepository->getAll();
	}


	/**
	 * @param Wall $wall
	 * @param string $name
	 * @param string $description
	 * @param string $applicationToken
	 * @param Language $primaryLanguage
	 * @param string $primaryLanguageUrl
	 * @return Wall
	 */
	public function initWall(Wall $wall, $name, $description, $applicationToken, Language $primaryLanguage, $primaryLanguageUrl)
	{
		$wall->setName($name)
			->setApplication($this->createApplication($wall, $name, $description, $applicationToken))
			->setPrimaryLanguage($this->createPrimaryLanguage($wall, $primaryLanguage, $description, $primaryLanguageUrl));

		$this->wallRepository->save($wall);
		return $wall;
	}


	/**
	 * @param Wall $wall
	 * @param string $name
	 * @param string $description
	 * @param string $token
	 * @return Application
	 */
	private function createApplication(Wall $wall, $name, $description, $token)
	{
		return (new Application)->setName($name)
			->setDescription($description)
			->setToken($token)
			->setWall($wall);
	}


	/**
	 * @param Wall $wall
	 * @param Language $language
	 * @param string $description
	 * @param string $url
	 * @return WallLanguage
	 */
	private function createPrimaryLanguage(Wall $wall, Language $language, $description, $url)
	{
		$wallTranslation = (new WallTranslation)->setDescription($description);
		$wallLanguage = (new WallLanguage)->setWall($wall)
			->setLanguage($language)
			->setUrl($url)
			->setWallTranslation($wallTranslation);
		$wall->addWallLanguage($wallLanguage);
		return $wallLanguage;
	}

}
