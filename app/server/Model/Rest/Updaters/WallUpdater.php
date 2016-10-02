<?php

namespace GoClimb\Model\Rest\Updaters;

use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Entities\WallTranslation;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Model\Rest\Utils;
use stdClass;


class WallUpdater
{

	/** @var WallRepository */
	private $wallRepository;


	public function __construct(WallRepository $wallRepository)
	{
		$this->wallRepository = $wallRepository;
	}


	/**
	 * @param Wall $wall
	 * @param stdClass $data
	 * @throws MappingException
	 * @return Wall
	 */
	public function updateDetails(Wall $wall, stdClass $data = NULL)
	{
		if (!$data) {
			throw MappingException::invalidData();
		}

		Utils::updateProperties($wall, $data, [
			'name' => TRUE,
			'street' => FALSE,
			'number' => FALSE,
			'country' => FALSE,
			'zip' => FALSE,
		]);

		foreach ($data->description as $lang => $description) {
			if (!$wallLanguage = $wall->getWallLanguage($lang)) {
				throw MappingException::invalidTranslation($lang);
			}

			if (!$wallTranslation = $wallLanguage->getWallTranslation()) {
				$wallTranslation = new WallTranslation;
				$wallLanguage->setWallTranslation($wallTranslation);

			}
			$wallTranslation->setDescription($description);
		}

		$this->wallRepository->save($wall);

		return $wall;
	}

}
