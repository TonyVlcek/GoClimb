<?php

namespace GoClimb\Modules;

use GoClimb\Model\Repositories\LoginTokenRepository;
use Kdyby\Translation\Translator;
use Nette\Application\Request;
use Nette\Application\UI\Presenter;
use Nette\Reflection\ClassType;
use Nette\Reflection\Method;
use GoClimb\Annotations\RecursiveClassParser;
use GoClimb\Annotations\RecursiveMethodParser;
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

	/** @var RecursiveClassParser */
	private $classParser;

	/** @var RecursiveMethodParser */
	private $methodParser;

	/** @var ApplicationPartsManager */
	protected $applicationPartsManager;

	/** @var  LoginTokenRepository */
	protected $loginTokenRepository;


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


	public function injectEssentials(Translator $translator, ApplicationPartsManager $applicationPartsManager, LoginTokenRepository $loginTokenRepository)
	{
		$this->translator = $translator;
		$this->applicationPartsManager = $applicationPartsManager;
		$this->loginTokenRepository = $loginTokenRepository;
	}


	public function injectAnnotationParsers(RecursiveClassParser $classParser, RecursiveMethodParser $methodParser)
	{
		$this->classParser = $classParser;
		$this->methodParser = $methodParser;
	}


	public function checkRequirements($element = NULL)
	{
		if ($element instanceof ClassType) {
			$this->resolveClassAnnotations($element, $this->classParser->parse($element));
		} elseif ($element instanceof Method) {
			$this->resolveMethodAnnotations($element, $this->methodParser->parse($element));
		}
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


	private function resolveClassAnnotations(ClassType $reflection, array $annotations)
	{
		$this->resolveUserAnnotations($annotations);
	}


	private function resolveMethodAnnotations(Method $reflection, array $annotations)
	{
		$this->resolveUserAnnotations($annotations);
	}


	/**
	 * @param array $annotations
	 */
	private function resolveUserAnnotations(array $annotations)
	{
		if (isset($annotations['loggedIn'])) {
			if (!$this->user->isLoggedIn()) {
				$this->redirect(isset($annotations['backLink']) ? reset($annotations['backLink']) : ':Public:Dashboard:default');
			}
		}
		if (isset($annotations['allowed'])) {
			foreach ($annotations['allowed'] as $allowed) {
				list ($resource, $privilege) = explode(' ', trim($allowed), 2);
				if (!$this->user->isAllowed($resource, $privilege)) {
					$this->redirect(isset($annotations['backLink']) ? reset($annotations['backLink']) : ':Public:Dashboard:default');
				}
			}
		}
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
	 * @return string
	 */
	abstract protected function getApplicationToken();

}
