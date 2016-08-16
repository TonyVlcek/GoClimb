<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Facades\WallFacade;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Model\Rest\Mappers\WallMapper;
use GoClimb\Model\Rest\Updaters\WallUpdater;


class DetailsPresenter extends BaseV1Presenter
{

	/** @var WallFacade */
	private $wallFacade;

	/** @var WallRepository */
	private $wallRepository;

	/** @var WallUpdater */
	private $wallUpdater;


	public function __construct(WallFacade $wallFacade, WallRepository $wallRepository, WallUpdater $wallUpdater)
	{
		parent::__construct();
		$this->wallFacade = $wallFacade;
		$this->wallRepository = $wallRepository;
		$this->wallUpdater = $wallUpdater;
	}


	public function actionDefault()
	{
		if ($this->getHttpRequest()->isMethod('GET')) {
			$this->getDetails();
		} elseif ($this->getHttpRequest()->isMethod('POST')) {
			$this->postDetails();
		} else {
			$this->sendMethodNotAllowed();
		}
	}


	public function getDetails()
	{
		$this->addData('details', WallMapper::mapDetails($this->wall));
	}


	public function postDetails()
	{
		try {
			$this->wallUpdater->updateDetails($this->wall, $this->getData('details'));
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}

		$this->getDetails();
	}

}
