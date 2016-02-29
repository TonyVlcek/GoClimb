<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Modules\WallModule;

use GoClimb\Model\Entities\Wall;
use GoClimb\Modules\BasePresenter;
use GoClimb\NotImplementedException;
use Nette\Application\Request;


abstract class BaseWallPresenter extends BasePresenter
{

	/** @var Wall */
	protected $wall;


	protected function init(Request $request)
	{
		$wall = $request->getParameter('wall');
		$this->applicationPartsManager->setAsWallSite($wall);
		$this->wall = $wall;
	}


	/**
	 * @inheritdoc
	 */
	protected function getApplicationToken()
	{
		throw new NotImplementedException;
	}

}
