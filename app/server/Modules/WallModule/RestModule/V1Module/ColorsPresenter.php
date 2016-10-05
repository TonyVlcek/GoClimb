<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Entities\Color;
use GoClimb\Model\Repositories\ColorRepository;


class ColorsPresenter extends BaseV1Presenter
{

	/** @var ColorRepository */
	private $colorRepository;


	public function __construct(ColorRepository $colorRepository)
	{
		parent::__construct();
		$this->colorRepository = $colorRepository;
	}


	public function actionGet()
	{
		$this->addData('colors', array_map(function (Color $color) {
			return $color->getHash();
		}, $this->colorRepository->getGlobal()));
	}

}
