<?php

namespace GoClimb\Modules\WallModule;

use GoClimb\Model\Entities\Wall;
use GoClimb\Modules\BasePresenter;
use GoClimb\NotImplementedException;
use Nette\Application\Request;


abstract class BaseWallPresenter extends BasePresenter
{

	/** @var Wall @persistent */
	public $wall;


	protected function init(Request $request)
	{
		$this->applicationPartsManager->setAsWallSite($request->getParameter('wall'));
	}


	public function beforeRender()
	{
		parent::beforeRender();
		$languages = [];
		foreach ($this->wall->getWallLanguages() as $wallLanguage) {
			$shortcut = $wallLanguage->getLanguage()->getShortcut();
			$languages[$shortcut] = $this->link('//this', ['path' => '__PATH__', 'locale' => $shortcut]);
		}
		$this->template->availableLanguages = $languages;
	}


	/**
	 * @inheritdoc
	 */
	protected function getApplicationToken()
	{
		throw new NotImplementedException;
	}

}
