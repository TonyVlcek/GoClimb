<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Facades\RestFacade;
use GoClimb\Modules\WallModule\RestModule\BaseRestPresenter;
use GoClimb\Security\Identity;
use Nette\Application\Request;
use Nette\Utils\ArrayHash;
use Nette\Utils\DateTime;
use Nette\Utils\Validators;


abstract class BaseV1Presenter extends BaseRestPresenter
{

	const E_TOKEN_INVALID = 600;
	const E_TOKEN_EXPIRED = 601;
	const E_TOKEN_INVALID_IP = 602;

	/** @var RestFacade */
	protected $restFacade;


	protected function init(Request $request)
	{
		$this->applicationPartsManager->setAsRest();
	}


	public function injectV1Parameters(RestFacade $restFacade)
	{
		$this->restFacade = $restFacade;
	}


	public function startup()
	{
		parent::startup();
		$this->payload->status = [
			'code' => 200,
			'message' => 'OK',
		];
		$this->payload->data = new ArrayHash;

		if ($token = $this->getParameter('token')) {
			if (($restToken = $this->restFacade->getRestToken($token)) && ($restToken->getWall() === $this->wall)) {
				if ($restToken->getExpiration() < new DateTime) {
					$this->sendError(self::E_TOKEN_EXPIRED, 'REST token expired');
				} elseif ($restToken->getRemoteIp() !== $this->getClientIp()) {
					$this->sendError(self::E_TOKEN_INVALID_IP, 'IP address invalid for this token');
				} else {
					$this->user->login(new Identity($restToken->getUser()));
				}
			} else {
				$this->sendError(self::E_TOKEN_INVALID, 'Invalid REST token');
			}
		} else {
			$this->user->logout(TRUE);
		}
	}


	public function beforeRender()
	{
		if (!(isset($this->payload->status) && Validators::is($this->payload->status['code'], 'int') && Validators::is($this->payload->status['message'], 'string'))) {
			$this->sendServerError('Status not set');
		}

		parent::beforeRender();
	}


	/**
	 * @param string $key
	 * @param mixed $value
	 * @return $this
	 */
	protected function addData($key, $value)
	{
		$this->payload->data->$key = $value;
		return $this;
	}


	/**
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	protected function getData($key, $default = NULL)
	{
		$body = $this->getRequestBody();
		return isset($body->$key) ? $body->$key : $default;
	}


	/**
	 * @param int $code
	 * @param string $message
	 */
	protected function sendError($code, $message)
	{
		$this->getHttpResponse()->setCode($code > 599 ? 401 : $code); // for our custom codes use 401 Unauthorized
		$this->sendJson([
			'status' => [
				'code' => $code,
				'message' => $message,
			],
		]);
	}


	protected function sendForbidden()
	{
		$this->sendError(403, 'Forbidden');
	}


	protected function sendNotFound()
	{
		$this->sendError(404, 'Not Found');
	}



	protected function sendMethodNotAllowed()
	{
		$this->sendError(405, 'Method Not Allowed');
	}


	/**
	 * @param string $message
	 */
	protected function sendUnprocessableEntity($message)
	{
		$this->sendError(422, $message);
	}


	/**
	 * @param string $message
	 */
	protected function sendServerError($message = 'Internal Server Error')
	{
		$this->sendError(500, $message);
	}


	/**
	 * @return string
	 */
	protected function getClientIp()
	{
		return $this->getHttpRequest()->getRemoteAddress();
	}


	/**
	 * @internal
	 * @return mixed
	 */
	protected function getRequestBody()
	{
		return json_decode(file_get_contents("php://input"));
	}

}
