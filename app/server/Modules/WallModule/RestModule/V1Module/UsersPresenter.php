<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Facades\ArticleFacade;
use GoClimb\Model\Facades\UserFacade;
use GoClimb\Model\Rest\Mappers\ArticleMapper;


class UsersPresenter /*extends BaseV1Presenter*/
{

	/** @var UserFacade */
	private $userFacade;


	public function __construct(UserFacade $userFacade)
	{
		parent::__construct();
		$this->userFacade = $userFacade;
	}


	public function actionDefault($id = NULL)
	{
		switch ($this->getHttpRequest()->getMethod()) {
			case 'GET':
				if ($id === NULL) {
					$this->sendMethodNotAllowed();
					break;
				}
				$this->detail($id);
				break;
			case 'POST':
			case 'DELETE':
				$this->sendMethodNotAllowed();
				break;

			default:
				$this->sendMethodNotAllowed();
				break;
		}
	}


	public function detail($id)
	{
		$user = $this->userFacade->getById($id);
		$this->addData('user', ArticleMapper::map($user));
	}

}
