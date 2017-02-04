<?php
/**
 * @author Martin Mikšík
 */

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\Repositories\RouteRepository;
use server\DI\Labels\LabelsGenerator;


class LabelsPresenter extends BaseV1Presenter
{

	/** @var RouteRepository */
	private $routeRepository;

	/** @var LabelsGenerator */
	private $labelsGenerator;


	public function __construct(RouteRepository $routeRepository, LabelsGenerator $labelsGenerator)
	{
		parent::__construct();
		$this->routeRepository = $routeRepository;
		$this->labelsGenerator = $labelsGenerator;
	}


	public function actionGet($id = NULL)
	{
		if (!$id) {
			$this->sendError('400', 'Invalid data');
		}

		$routesId = explode(',', $id);

		if (!$this->user->isAllowed(AclResource::ADMIN_ROUTES_ROPE) || !$this->user->isAllowed(AclResource::ADMIN_ROUTES_BOULDER)) {
			$this->sendForbidden();
		}

		foreach ($routesId as $routeId) {
			if ($route = $this->routeRepository->getById($routeId)) {
				if ($route->isRope()) {
					$this->labelsGenerator->addRope($route);
				} else {
					$this->labelsGenerator->addBoulder($route);
				}
			} else {
				$this->sendError('400', 'Invalid id');
			}
		}

		$this->sendResponse($this->labelsGenerator);
	}


	public function actionPost()
	{
		$this->sendMethodNotAllowed();
	}


	public function actionDelete($id = NULL)
	{
		$this->sendMethodNotAllowed();
	}

}
