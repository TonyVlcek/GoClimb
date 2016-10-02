<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\WallModule\RestModule\V1Module;

use GoClimb\Model\Repositories\ParameterRepository;
use GoClimb\Model\Rest\Mappers\ParameterMapper;


class ParametersPresenter extends BaseV1Presenter
{

	/** @var ParameterRepository */
	private $parameterRepository;


	public function __construct(ParameterRepository $parameterRepository)
	{
		parent::__construct();
		$this->parameterRepository = $parameterRepository;
	}


	public function actionGet()
	{
		$this->addData('parameters', ParameterMapper::mapArray($this->parameterRepository->getAll()));
	}

}
