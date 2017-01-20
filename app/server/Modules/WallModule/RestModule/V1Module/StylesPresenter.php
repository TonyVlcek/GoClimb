<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Enums\Style;
use GoClimb\Model\Repositories\LogRepository;
use GoClimb\Model\Repositories\RouteRepository;
use GoClimb\Model\Repositories\StyleRepository;
use GoClimb\Model\Rest\Mappers\StyleMapper;


class StylesPresenter extends BaseV1Presenter
{

	/** @var StyleRepository */
	private $styleRepository;

	/** @var LogRepository */
	private $logRepository;

	/** @var RouteRepository */
	private $routeRepository;

	public function __construct(StyleRepository $styleRepository, LogRepository $logRepository, RouteRepository $routeRepository)
	{
		parent::__construct();
		$this->styleRepository = $styleRepository;
		$this->logRepository = $logRepository;
		$this->routeRepository = $routeRepository;
	}


	public function actionGet($id = NULL)
	{
		$expect = [];
		$route = NULL;
		if (!$id || !$route = $this->routeRepository->getById($id)){
			$this->sendNotFound();
		}

		if ($route){
			if ($route->isBoulder()){
				$expect[] = Style::AF;
				$expect[] = Style::PP2;
			} else {
				$expect[] = Style::SOLO;
			}

			if($this->user->isLoggedIn() && $log = $this->logRepository->getByUserAndRoute($this->user->getUserEntity(), $route)) {
				$expect[] = Style::FLASH;
				$expect[] = Style::OS;
			}
		}

		$this->addData('styles', StyleMapper::mapArray($this->styleRepository->getExpect($expect)));
	}

}
