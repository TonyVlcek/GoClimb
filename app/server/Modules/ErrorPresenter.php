<?php

namespace GoClimb\Modules;

use Kdyby\Translation\Translator;
use Nette\Application\BadRequestException;
use Nette\Application\IPresenter;
use Nette\Application\Request;
use Nette\Application\Responses;
use Nette\Application\Responses\CallbackResponse;
use Nette\Application\Responses\ForwardResponse;
use Tracy\ILogger;


final class ErrorPresenter implements IPresenter
{

	/** @var ILogger */
	private $logger;

	/** @var Translator */
	private $translator;


	public function __construct(ILogger $logger, Translator $translator)
	{
		$this->logger = $logger;
		$this->translator = $translator;
	}


	public function run(Request $request)
	{
		$exception = $request->getParameter('exception');

		if ($exception instanceof BadRequestException) {
			return new ForwardResponse($request->setPresenterName('Error4xx'));
		}

		$this->logger->log($exception, ILogger::EXCEPTION);
		return new CallbackResponse(function () {
			require __DIR__ . '/templates/Error/500.phtml';
		});
	}

}
