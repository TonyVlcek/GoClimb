<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\RestModule\V1Module;

use GoClimb\Model\Entities\Boulder;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\BoulderRepository;
use GoClimb\Model\Rest\Mappers\BoulderMapper;
use GoClimb\Model\Rest\Updaters\BoulderUpdater;


class BouldersPresenter extends BaseV1Presenter
{

	/** @var BoulderRepository */
	private $boulderRepository;

	/** @var BoulderUpdater */
	private $boulderUpdater;


	public function __construct(BoulderRepository $boulderRepository, BoulderUpdater $boulderUpdater)
	{
		parent::__construct();
		$this->boulderRepository = $boulderRepository;
		$this->boulderUpdater = $boulderUpdater;
	}


	public function actionGet()
	{
		$this->addBouldersData($this->boulderRepository->getByWall($this->wall));
	}


	public function actionPost($id = NULL)
	{
		$this->checkPermissions();
		try {
			if ($id === NULL) {
				$boulder = new Boulder;
				$boulder->setBuilder($this->getUser()->getUserEntity());
			} else {
				$boulder = $this->getBoulder($id);
			}
			$this->boulderUpdater->updateBoulder($boulder, $this->getData('boulder'));
			$this->addBoulderData($boulder);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	public function actionDelete($id = NULL)
	{
		$this->checkPermissions();
		try {
			if (!$id || !$boulder = $this->boulderRepository->getById($id)) {
				$this->sendNotFound();
			} else {
				$this->boulderRepository->remove($boulder);
				$this->addBoulderData($boulder);
			}
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	/**
	 * @param Boulder[] $boulders
	 */
	public function addBouldersData(array $boulders)
	{
		$this->addData('boulders', BoulderMapper::mapArray($boulders));
	}


	/**
	 * @param Boulder $boulder
	 */
	public function addBoulderData(Boulder $boulder)
	{
		$this->addData('boulder', BoulderMapper::map($boulder));
	}


	/**
	 * @param int $id
	 * @return Boulder
	 */
	private function getBoulder($id)
	{
		if (!($boulder = $this->boulderRepository->getById($id)) || $boulder->getLine()->getSector()->getWall() !== $this->wall) {
			$this->sendNotFound();
		}
		return $boulder;
	}


	private function checkPermissions()
	{
		if (!$this->user->isAllowed(AclResource::ADMIN_ROUTES_BOULDER)) {
			$this->sendForbidden();
		}
	}

}
