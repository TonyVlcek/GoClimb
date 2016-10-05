<?php

namespace GoClimb\Modules;

use GoClimb\Model\Repositories\LoginTokenRepository;
use GoClimb\UI\CdnLinkGenerator;
use Kdyby\Translation\Translator;
use Nette\Application\Request;
use Nette\Application\UI\Presenter;
use GoClimb\Security\ApplicationPartsManager;
use GoClimb\Security\Identity;
use GoClimb\Security\User;
use stdClass;


/**
 * @property-read User $user
 */
abstract class BasePresenter extends Presenter
{

	const TOKEN_PLACEHOLDER = '__TOKEN__';
	const LOGIN_PARAMETER = 'loginToken';
	const LOGOUT_PARAMETER = 'logout';


	/** @var string @persistent */
	public $locale;

	/** @var Translator */
	protected $translator;

	/** @var ApplicationPartsManager */
	protected $applicationPartsManager;

	/** @var  LoginTokenRepository */
	protected $loginTokenRepository;

	/** @var CdnLinkGenerator */
	protected $cdnLinkGenerator;


	public function run(Request $request)
	{
		$this->init($request);
		return parent::run($request);
	}


	abstract protected function init(Request $request);


	/**
	 * @return User
	 */
	public function getUser()
	{
		return parent::getUser();
	}


	public function injectEssentials(Translator $translator, ApplicationPartsManager $applicationPartsManager, LoginTokenRepository $loginTokenRepository, CdnLinkGenerator $imageLinkGenerator)
	{
		$this->translator = $translator;
		$this->applicationPartsManager = $applicationPartsManager;
		$this->loginTokenRepository = $loginTokenRepository;
		$this->cdnLinkGenerator = $imageLinkGenerator;
	}


	/**
	 * @param string $message
	 * @param array $parameters
	 * @return stdClass
	 */
	public function flashMessageSuccess($message, array $parameters = [])
	{
		return $this->flashMessage($message, 'success', $parameters);
	}


	/**
	 * @param string $message
	 * @param array $parameters
	 * @return stdClass
	 */
	public function flashMessageError($message, array $parameters = [])
	{
		return $this->flashMessage($message, 'danger', $parameters);
	}


	protected function startup()
	{
		parent::startup();
		if ($this->getParameter($this::LOGOUT_PARAMETER)) {
			$this->resolveLogout();
		} elseif ($token = $this->getParameter($this::LOGIN_PARAMETER)) {
			$this->resolveLogin($token);
		}

		if ($this->translator->getLocale() !== $this->locale) {
			$this->redirect('this', ['locale' => $this->translator->getLocale()]);
		}
	}


	public function beforeRender()
	{
		parent::beforeRender();
		$this->template->cdn = function ($name) {
			return $this->cdnLinkGenerator->generateLink($name);
		};
	}


	/**
	 * @param string $token
	 */
	protected function resolveLogin($token)
	{
		if ($token === '') {
			$this->user->logout(TRUE);
			$this->flashMessageError('user.login.error');
		} elseif ($token = $this->loginTokenRepository->getByToken($token)) {
			$user = $token->getUser();
			$this->user->login(new Identity($user));
			if ($token->isLongTerm()) {
				$this->user->setExpiration('+10 days', FALSE, TRUE);
			} else {
				$this->user->setExpiration('+48 hours', TRUE, TRUE);
			}

			$this->flashMessageSuccess('user.login.success');
		}
		$this->redirect('this', ['token' => NULL]);
	}


	public function resolveLogout()
	{
		$this->user->logout(TRUE);
		$this->flashMessageSuccess('user.logout.success');
		$this->redirect('this');
	}


	/**
	 * @param string $message
	 * @param string $type
	 * @param array $parameters
	 * @return stdClass
	 */
	public function flashMessage($message, $type = 'info', array $parameters = [])
	{
		return parent::flashMessage($this->translator->translate('messages.' . $message, $parameters), $type);
	}


	/**
	 * @param string $applicationToken
	 * @param string $backlink
	 * @return string
	 */
	public function getLoginLink($applicationToken, $backlink)
	{
		return $this->link('//:Auth:Dashboard:login', ['token' => $applicationToken, 'back' => $backlink]);
	}


	/**
	 * @param string $applicationToken
	 * @param string $backlink
	 * @return string
	 */
	public function getLogoutLink($applicationToken, $backlink)
	{
		return $this->link('//:Auth:Dashboard:logout', ['token' => $applicationToken, 'back' => $backlink]);
	}


	/**
	 * @param string $applicationToken
	 * @param string $backlink
	 * @return string
	 */
	public function getRegisterLink($applicationToken, $backlink)
	{
		return $this->link('//:Auth:Dashboard:register', ['token' => $applicationToken, 'back' => $backlink]);
	}


	/**
	 * @return string
	 */
	abstract protected function getApplicationToken();

}
