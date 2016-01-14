<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\UI\Controls;

use Kdyby\Translation\Translator;
use Nette\Application\UI\Control;
use OnlineClimbing\UI\FileException;


abstract class BaseControl extends Control
{

	/** @var Translator */
	protected $translator;

	/**
	 * @return string
	 */
	abstract public function getDomain();


	/**
	 * @param Translator $translator
	 */
	public function setTranslator(Translator $translator)
	{
		$this->translator = $translator->domain('components.' . $this->getDomain());
	}


	/**
	 * @throws FileException
	 */
	public function render()
	{
		$fileName = str_replace('.php', '.latte', $this->getReflection()->getFileName());
		if (!file_exists($fileName)) {
			throw FileException::notFound($fileName);
		}
		$this->template->setFile($fileName);
		$this->template->render();
	}
}
