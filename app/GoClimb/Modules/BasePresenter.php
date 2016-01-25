<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules;

use Kdyby\Translation\Translator;
use Nette\Application;
use Nette\Application\UI\Presenter;
use Nette\Reflection\ClassType;
use Nette\Reflection\Method;
use GoClimb\Annotations\RecursiveClassParser;
use GoClimb\Annotations\RecursiveMethodParser;
use GoClimb\Model\Facades\AuthFacade;
use GoClimb\Security\ApplicationPartsManager;
use GoClimb\Security\Identity;
use GoClimb\Security\User;
use stdClass;


/**
 * @property-read User $user
 */
abstract class BasePresenter extends Presenter
{

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

	/** @var AuthFacade */
	protected $authFacade;


	public function run(Application\Request $request)
	{
		$this->init();
		return parent::run($request);
	}


	abstract protected function init();


	/**
	 * @return User
	 */
	public function getUser()
	{
		return parent::getUser();
	}


	public function injectEssentials(Translator $translator, ApplicationPartsManager $applicationPartsManager, AuthFacade $authFacade)
	{
		$this->translator = $translator;
		$this->applicationPartsManager = $applicationPartsManager;
		$this->authFacade = $authFacade;
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
		if ($this->translator->getLocale() !== $this->locale) {
			$this->redirect('this', ['locale' => $this->translator->getLocale()]);
		}
	}


	public function handleTokenLogin($token)
	{
		$this->resolveLogin($token);
	}


	protected function resolveLogin($token)
	{
		if ($token === '') {
			$this->user->logout(TRUE);
		} elseif ($user = $this->authFacade->getUserByToken($token)) {
			$this->user->login(new Identity($user));
		}
		$this->redirect('this', ['token' => NULL]);
	}


	private function resolveClassAnnotations(ClassType $reflection, array $annotations)
	{
		$this->resolveUserAnnotations($annotations);
	}


	private function resolveMethodAnnotations(Method $reflection, array $annotations)
	{
		$this->resolveUserAnnotations($annotations);
	}


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

}