<?php

namespace GoClimb\Model\Rest\Updaters;

use GoClimb\Model\Entities\CurrentNews;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Facades\UserFacade;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\CurrentNewsRepository;
use GoClimb\Security\User;
use Nette\Utils\DateTime;
use stdClass;


class CurrentNewsUpdater
{

	/** @var CurrentNewsRepository */
	private $currentNewsRepository;


	public function __construct(CurrentNewsRepository $currentNewsRepository)
	{
		$this->currentNewsRepository = $currentNewsRepository;
	}


	/**
	 * @param CurrentNews $currentNews
	 * @param stdClass $data
	 * @throws MappingException
	 * @return CurrentNews
	 */
	public function updateCurrentNews(CurrentNews $currentNews, stdClass $data = NULL)
	{
		if (!$data) {
			throw MappingException::invalidData();
		}

		$properties = [
			'name' => TRUE,
			'content' => TRUE,
		];

		foreach ($properties as $field => $required) {
			if ((!property_exists($data, $field)) || ($required && ($data->$field === NULL))) {
				throw MappingException::invalidField($field, $required);
			}

			$method = 'set' . ucfirst($field);
			$currentNews->$method($data->$field);
		}

		if (isset($data->published) && !$currentNews->isPublished() && $data->published) {
			$currentNews->publish();
		}

		$this->currentNewsRepository->save($currentNews);
	}

}
