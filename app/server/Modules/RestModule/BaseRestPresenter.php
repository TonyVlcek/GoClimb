<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\RestModule;

use GoClimb\Modules\BasePresenter;
use Nette\Application\Request;
use Nette\InvalidStateException;


abstract class BaseRestPresenter extends BasePresenter
{

	public function beforeRender()
	{
		$this->sendPayload();
	}


	protected function init(Request $request)
	{
		$this->applicationPartsManager->setAsRest();
	}


	/**
	 * @return string
	 */
	protected function getApplicationToken()
	{
		throw new InvalidStateException;
	}
}
