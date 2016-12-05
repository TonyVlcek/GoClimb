<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\RestModule\V1Module;

use GoClimb\Model\Repositories\StyleRepository;
use GoClimb\Model\Rest\Mappers\StyleMapper;


class StylesPresenter extends BaseV1Presenter
{

	/** @var StyleRepository */
	private $styleRepository;


	public function __construct(StyleRepository $styleRepository)
	{
		parent::__construct();
		$this->styleRepository = $styleRepository;
	}


	public function actionGet()
	{
		$this->addData('styles', StyleMapper::mapArray($this->styleRepository->getAll()));
	}

}
