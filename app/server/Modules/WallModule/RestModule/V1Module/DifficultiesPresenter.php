<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Repositories\DifficultyRepository;
use GoClimb\Model\Rest\Mappers\DifficultyMapper;


class DifficultiesPresenter extends BaseV1Presenter
{


	/** @var DifficultyRepository */
	private $difficultyRepository;


	public function __construct(DifficultyRepository $difficultyRepository)
	{
		parent::__construct();
		$this->difficultyRepository = $difficultyRepository;
	}

	public function actionGet()
	{
		$this->addData('difficulties', DifficultyMapper::mapArray($this->difficultyRepository->getAll()));
	}

}
