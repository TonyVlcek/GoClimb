<?php

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Modules\WallModule\RestModule\BaseRestPresenter;
use Nette\Utils\ArrayHash;
use Nette\Utils\Validators;


abstract class BaseV1Presenter extends BaseRestPresenter
{

	public function startup()
	{
		parent::startup();
		$this->payload->status = [
			'code' => 200,
			'message' => 'OK',
		];
		$this->payload->data = new ArrayHash;
	}


	public function beforeRender()
	{
		if (!(isset($this->payload->status) && Validators::is($this->payload->status['code'], 'int') && Validators::is($this->payload->status['message'], 'string'))) {
			$this->sendServerError('Status not set');
		}

		parent::beforeRender();
	}


	/**
	 * @param int $code
	 * @param string $message
	 */
	protected function sendError($code, $message)
	{
		$this->getHttpResponse()->setCode($code);
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
	 * @internal
	 * @return mixed
	 */
	protected function getRequestBody()
	{
		return json_decode(file_get_contents("php://input"));
	}

}
