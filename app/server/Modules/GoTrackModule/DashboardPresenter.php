<?php

namespace GoClimb\Modules\GoTrackModule;

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Facades\RestFacade;
use GoClimb\Modules\BasePresenter;
use GoClimb\Security\Identity;
use Nette\Application\Request;
use Nette\Utils\ArrayHash;


class DashboardPresenter extends BasePresenter
{


	/** @var RestFacade */
	private $restFacade;


	public function __construct(RestFacade $restFacade)
	{
		parent::__construct();
		$this->restFacade = $restFacade;
	}


	protected function init(Request $request)
	{
		$this->applicationPartsManager->setAsGoTrack();
	}


	protected function getApplicationToken()
	{
		return Application::GOTRACK_TOKEN;
	}


	public function beforeRender()
	{
		$this->sendPayload();
	}


	public function startup()
	{
		parent::startup();

//		dump($this->user->isLoggedIn());

		if (!$this->user->isLoggedIn()) {
			$loginBacklink = $this->link('//this', [$this::LOGIN_PARAMETER => $this::TOKEN_PLACEHOLDER]);
			$loginLink = $this->getLoginLink($this->getApplicationToken(), $loginBacklink);
			$this->redirectUrl($loginLink);
		}


		$this->payload->status = [
			'code' => 200,
			'message' => 'OK',
		];

		$this->payload->data = new ArrayHash;


//		$token = $this->loginTokenRepository->getByToken($token);
//		$user = $token->getUser();

//		dump($token);
//		dump($user);
//		$this->user->login(new Identity($user));
		$httpResponse = $this->getHttpResponse();

//		$this->presenter->redirectUrl("GoTrackReact://?getToken={$this->link('://:GoTrack:Dashboard:default')}");
//		$this->presenter->redirectUrl("GoTrackReact://getToken={$this->link('//:GoTrack:Dashboard:default");
	}


	protected function resolveLogin($token)
	{
		if ($token === '') {
			$this->user->logout(TRUE);
		} elseif ($token = $this->loginTokenRepository->getByToken($token)) {
			$user = $token->getUser();
			$this->user->login(new Identity($user));
			$this->presenter->redirectUrl("GoTrackReact://?getToken={$this->link('://:GoTrack:Dashboard:default')}");
//			dump($this->user);
		}
	}

//	public function actionDefault() {
//		$this->payload->data = [
//			'apiUrl' => $this->link('//:Rest:V1:Dashboard:default'),
//			'restToken' => $this->user->isLoggedIn() ? $this->restFacade->getOrGenerateGlobalRestToken($this->user->getUserEntity(), $this->getHttpRequest()->getRemoteAddress())->getToken() : NULL,
//			'cdnUrl' => $this->cdnLinkGenerator->getCdnUrl(),
////			'user' => $this->user->isLoggedIn() ? UserMapper::mapBasicInfo($this->user->getUserEntity()) : NULL,
//		];
//	}


	public function actionGet()
	{
		$this->payload->data = [
			'apiUrl' => $this->link('//:Rest:V1:Dashboard:default'),
			'restToken' => $this->user->isLoggedIn() ? $this->restFacade->getOrGenerateGlobalRestToken($this->user->getUserEntity(), $this->getHttpRequest()->getRemoteAddress())->getToken() : NULL,
//			'cdnUrl' => $this->cdnLinkGenerator->getCdnUrl(),
//			'user' => $this->user->isLoggedIn() ? UserMapper::mapBasicInfo($this->user->getUserEntity()) : NULL,
		];
	}


}
