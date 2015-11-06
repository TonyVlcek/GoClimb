<?php
/**
 * @author Tomáš Blatný
 */

namespace App\Presenters;

use Kdyby\Translation\Translator;
use Nette\Application\UI\Presenter;


class BasePresenter extends Presenter
{

	/** @var string @persistent */
	public $locale;

	/** @var Translator @inject */
	public $translator;

}
