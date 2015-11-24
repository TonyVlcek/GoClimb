<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Modules;

use Kdyby\Translation\Translator;
use Nette\Application\UI\Presenter;
use Nette\Reflection\ClassType;
use Nette\Reflection\Method;
use OnlineClimbing\Annotations\RecursiveClassParser;
use OnlineClimbing\Annotations\RecursiveMethodParser;


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


	public function injectEssentials(Translator $translator, RecursiveClassParser $classParser, RecursiveMethodParser $methodParser)
	{
		$this->translator = $translator;
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


	protected function startup()
	{
		parent::startup();
		if ($this->translator->getLocale() !== $this->locale) {
			$this->redirect('this', ['locale' => $this->translator->getLocale()]);
		}
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

}
