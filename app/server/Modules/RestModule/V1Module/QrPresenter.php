<?php
/**
 * @author Martin Mikšík
 */

namespace GoClimb\Modules\RestModule\V1Module;

use GoClimb\Model\Repositories\RouteRepository;


class QrPresenter extends BaseV1Presenter
{

	/** @var RouteRepository */
	private $routeRepository;


	public function __construct(RouteRepository $routeRepository)
	{
		parent::__construct();
		$this->routeRepository = $routeRepository;
	}


	public function actionGet($id)
	{
		$route = $this->routeRepository->getById($id);

		if (!$route) {
			$this->sendNotFound();
		}

		$type = $route->isBoulder() ? 'boulder' : 'rope';
		$wall = $route->getLine()->getSector()->getWall();
		$url = $this->link('//:Wall:Front:Dashboard:default', ['wall' => $wall, 'locale' => $wall->getPrimaryLanguage()->getLanguage()->getShortcut()]);
		$this->redirectUrl($url . 'create/log/' . $type . '/' . $id);
	}
}
