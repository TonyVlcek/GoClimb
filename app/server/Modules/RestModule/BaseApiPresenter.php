<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\RestModule;

use Drahak\Restful\Application\UI\ResourcePresenter;
use Drahak\Restful\IResource;


abstract class BaseApiPresenter extends ResourcePresenter
{

	public function beforeRender()
	{
		$this->sendJson();
	}


	public function sendJson($data = NULL)
	{
		$this->sendResource(IResource::JSON);
	}

}
