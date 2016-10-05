<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Facades\UserFacade;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Rest\Mappers\UserMapper;


class UsersPresenter extends BaseV1Presenter
{

	/** @var UserFacade */
	private $userFacade;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(UserFacade $userFacade, UserRepository $userRepository)
	{
		parent::__construct();

		$this->userFacade = $userFacade;
		$this->userRepository = $userRepository;
	}


	public function actionGet($id = NULL, $email = NULL)
	{

		if ($id !== NULL) {
			if (!$user = $this->userFacade->getById($id)) {
				$this->sendNotFound();
			}

			$this->addData('user', UserMapper::map($user));
		}

		if ($email !== NULL) {
			if (!$user = $this->userRepository->getByEmail($email)) {
				$this->sendNotFound();
			}

			$this->addData('user', UserMapper::map($user));
		}

	}

}
