<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Entities\Rope;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\RopeRepository;
use GoClimb\Model\Rest\Mappers\RopeMapper;
use GoClimb\Model\Rest\Updaters\RopeUpdater;


class RopesPresenter extends BaseV1Presenter
{

	/** @var RopeRepository */
	private $ropeRepository;

	/** @var RopeUpdater */
	private $ropeUpdater;


	public function __construct(RopeRepository $ropeRepository, RopeUpdater $ropeUpdater)
	{
		parent::__construct();
		$this->ropeRepository = $ropeRepository;
		$this->ropeUpdater = $ropeUpdater;
	}


	public function actionGet($id = NULL)
	{
		if (!$id) {
			if ($this->user->isAllowed('admin.routes.rope')) {
				$this->addRopesData($this->ropeRepository->getByWall($this->wall));
			} else {
				$this->addRopesData($this->ropeRepository->getStandingByWall($this->wall));
			}
		} elseif ($rope = $this->ropeRepository->getById($id)) {
			$this->addRopeData($rope);
		} else {
			$this->sendNotFound();
		}
	}


	public function actionPost($id = NULL)
	{
		$this->checkPermissions();
		try {
			if ($id === NULL) {
				$rope = new Rope;
			} else {
				$rope = $this->getRope($id);
			}
			$this->ropeUpdater->updateRope($rope, $this->getData('rope'));
			$this->addRopeData($rope);
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	public function actionDelete($id = NULL)
	{
		$this->checkPermissions();
		try {
			if (!$id || !$rope = $this->ropeRepository->getById($id)) {
				$this->sendNotFound();
			} else {
				$this->ropeRepository->remove($rope);
				$this->addRopeData($rope);
			}
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}


	/**
	 * @param Rope[] $ropes
	 */
	public function addRopesData(array $ropes)
	{
		$this->addData('ropes', RopeMapper::mapArray($ropes));
	}


	/**
	 * @param Rope $rope
	 */
	public function addRopeData(Rope $rope)
	{
		$this->addData('rope', RopeMapper::map($rope));
	}


	/**
	 * @param int $id
	 * @return Rope
	 */
	private function getRope($id)
	{
		if (!($rope = $this->ropeRepository->getById($id)) || $rope->getLine()->getSector()->getWall() !== $this->wall) {
			$this->sendNotFound();
		}
		return $rope;
	}


	private function checkPermissions()
	{
		if (!$this->user->isAllowed(AclResource::ADMIN_ROUTES_ROPE)) {
			$this->sendForbidden();
		}
	}

}
