<?php

namespace GoClimb\Modules\RestModule\V1Module;

use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Rest\Mappers\UserMapper;
use GoClimb\Model\Rest\Updaters\UserUpdater;


class UsersPresenter extends BaseV1Presenter
{

	/** @var UserRepository */
	private $userRepository;


	/** @var UserUpdater */
	private $userUpdater;


	public function __construct(UserRepository $userRepository, UserUpdater $userUpdater)
	{
		parent::__construct();

		$this->userRepository = $userRepository;
		$this->userUpdater = $userUpdater;
	}


	public function actionGet($id = NULL, $email = NULL)
	{
		if ($id !== NULL) {
			if (!$user = $this->userRepository->getById($id)) {
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


	public function actionPost($id = NULL)
	{
		try {
			if ($id === NULL) {
				$this->sendNotFound();
			}

			if ($id != $this->user->getId()) {
				$this->sendForbidden();
			}

			if (!$user = $this->userRepository->getById($id)) {
				$this->sendNotFound();
			}

			$this->userUpdater->updateUser($user, $this->getData('user'));
			$this->addData('user', UserMapper::map($user));
		} catch (MappingException $e) {
			$this->sendUnprocessableEntity($e->getMessage());
		}
	}

}
