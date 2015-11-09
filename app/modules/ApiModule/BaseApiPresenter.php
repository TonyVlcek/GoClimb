<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Modules\ApiModule;

use Drahak\Restful\Application\UI\ResourcePresenter;
use Drahak\Restful\IResource;


abstract class BaseApiPresenter extends ResourcePresenter
{

	public function beforeRender()
	{
		$this->resource->foo = 'bar';
		$this->sendJson();
	}


	public function sendJson($data = NULL)
	{
		$this->sendResource(IResource::JSON);
	}

}
