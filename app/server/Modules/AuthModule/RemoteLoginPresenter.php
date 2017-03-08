<?php

namespace GoClimb\Modules\AuthModule;

use GoClimb\Model\Facades\RestFacade;
use GoClimb\Model\Repositories\LoginTokenRepository;
use GoClimb\Security\Identity;
use Nette\ArrayHash;
use Nette\DateTime;
use Nette\Utils\Validators;


final class RemoteLoginPresenter extends BaseAuthPresenter
{
	/** @var RestFacade */
	protected $restFacade;

	/** @var LoginTokenRepository */
	protected $loginTokenRepository;


	public function __construct(RestFacade $restFacade, LoginTokenRepository $loginTokenRepository)
	{
		parent::__construct();

		$this->restFacade = $restFacade;
		$this->loginTokenRepository = $loginTokenRepository;
	}


	public function startup()
	{
		parent::startup();

		if(!$this->getUser()->isLoggedIn()){
			$this->sendError(500, 'User is not logged in. Try checking LOGIN TOKEN!');
		} else {

			$this->payload->status = [
				'code' => 200,
				'message' => 'OK',
			];

			$this->payload->data = new ArrayHash;
		}
	}


	public function beforeRender()
	{
		if (!(isset($this->payload->status) && Validators::is($this->payload->status['code'], 'int') && Validators::is($this->payload->status['message'], 'string'))) {
			$this->sendError(500, 'Status not set');
		}

		$this->sendPayload();
	}


	public function actionDefault()
	{
		$token = $this->restFacade->getOrGenerateGlobalRestToken($this->getUser()->getUserEntity(), $this->getHttpRequest()->getRemoteAddress())->getToken();
		$this->payload->data->restToken = $token;
		$this->user->logout(TRUE);
	}


	/**
	 * @param int $code
	 * @param string $message
	 */
	private function sendError($code, $message)
	{
		$this->getHttpResponse()->setCode($code > 599 ? 401 : $code); // for our custom codes use 401 Unauthorized
		$this->sendJson([
			'status' => [
				'code' => $code,
				'message' => $message,
			],
		]);
	}


}
