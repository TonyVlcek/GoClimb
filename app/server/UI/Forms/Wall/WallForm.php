<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\UI\Forms\Wall;

use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Facades\AclFacade;
use GoClimb\Model\Facades\WallFacade;
use GoClimb\Model\Repositories\LanguageRepository;
use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Security\User;
use GoClimb\UI\Forms\BaseBootstrapForm;
use GoClimb\UI\Forms\Form;
use GoClimb\UI\Forms\ITranslatableFormFactory;
use Kdyby\Translation\Translator;
use Nette\Utils\ArrayHash;


interface IWallFormFactory extends ITranslatableFormFactory
{

	/** @return WallForm */
	function create(Wall $wall);

}


class WallForm extends BaseBootstrapForm
{

	/** @var Wall */
	private $wall;

	/** @var WallRepository */
	private $wallRepository;

	/** @var LanguageRepository */
	private $languageRepository;

	/** @var WallFacade */
	private $wallFacade;

	/** @var User */
	private $user;

	/** @var AclFacade */
	private $aclFacade;

	/** @var Translator */
	private $originalTranslator;


	public function __construct(Wall $wall, WallRepository $wallRepository, LanguageRepository $languageRepository, WallFacade $wallFacade, User $user, AclFacade $aclFacade)
	{
		parent::__construct();
		$this->wall = $wall;
		$this->wallRepository = $wallRepository;
		$this->languageRepository = $languageRepository;
		$this->wallFacade = $wallFacade;
		$this->user = $user;
		$this->aclFacade = $aclFacade;
	}


	public function setTranslator(Translator $translator)
	{
		$this->originalTranslator = $translator;
		parent::setTranslator($translator);
	}


	/**
	 * @param Form $form
	 */
	public function init(Form $form)
	{
		$form->addText('name', 'fields.name')
			->setRequired('errors.name.required');

		$languages = [];
		foreach ($this->languageRepository->getAll() as $language) {
			$languages[$language->getId()] = $this->originalTranslator->translate('const.languages.' . $language->getConst());
		}

		$form->addSelect('language', $this->originalTranslator->translate('forms.wall.wallForm.fields.language'), $languages)
			->setPrompt($this->originalTranslator->translate('forms.wall.wallForm.prompts.language'))
			->setRequired($this->originalTranslator->translate('forms.wall.wallForm.errors.language.required'))
			->setTranslator(NULL);

		$form->addText('description', 'fields.description')
			->setRequired('errors.description.required');

		$form->addText('token', 'fields.token')
			->setRequired('errors.token.required');

		$form->addText('url', 'fields.url')
			->setRequired('errors.url.required');

		$form->addSubmit('save', 'fields.submit');
	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function validateForm(Form $form, ArrayHash $values)
	{

	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function formSuccess(Form $form, ArrayHash $values)
	{
		$language = $this->languageRepository->getById($values->language);
		$this->wallFacade->initWall($this->wall, $values->name, $values->description, $values->token, $language, $values->url);
		$this->aclFacade->initWallRoles($this->wall, $this->user->getUserEntity());
	}


	/**
	 * @return string
	 */
	public function getDomain()
	{
		return 'wall.wallForm';
	}
}
