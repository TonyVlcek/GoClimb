<?php

namespace GoClimb\UI\Forms\User;

use DateTime;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Query\Specifications\User\DuplicateNick;
use GoClimb\Model\Query\Specifications\User\DuplicateEmail;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\UI\Forms\BaseBootstrapForm;
use GoClimb\UI\Forms\Form;
use GoClimb\UI\Forms\ITranslatableFormFactory;
use Nette\Security\Passwords;
use Nette\Utils\ArrayHash;



interface IUserFormFactory extends ITranslatableFormFactory
{

	/** @return UserForm */
	function create(User $user);

}

/**
 * @method onCreate(User $user)
 * @method onEdit(User $user)
 */
class UserForm extends BaseBootstrapForm
{

	/** @var User */
	private $user;

	/** @var UserRepository */
	private $userRepository;

	/** @var callable[]*/
	public $onCreate;

	/** @var callable[] */
	public $onEdit;


	public function __construct(User $user, UserRepository $userRepository)
	{
		parent::__construct();
		$this->user = $user;
		$this->userRepository = $userRepository;
	}


	/**
	 * @inheritdoc
	 */
	public function init(Form $form)
	{
		$form->addText('nick', 'fields.nick')
			->setAttribute('placeholder', 'fields.nick');

		$form->addText('firstName', 'fields.firstName')
			->setAttribute('placeholder', 'fields.firstName');

		$form->addText('lastName', 'fields.lastName')
			->setAttribute('placeholder', 'fields.lastName');

		$form->addText('email', 'fields.email')
			->setType('email')
			->setAttribute('placeholder', 'fields.email');

		$form->addText('phone', 'fields.phone')
			->setType('phone')
			->setAttribute('placeholder', 'fields.phone');

		$form->addText('weight', 'fields.weight')
			->setType('number')
			->setAttribute('placeholder', 'fields.weight');

		$form->addText('height', 'fields.height')
			->setType('number')
			->setAttribute('placeholder', 'fields.height');

		$form->addText('birthDate', 'fields.birthDate')
			->setType('date')
			->setAttribute('placeholder', 'fields.birthDate');

		$form->addText('climbingSince', 'fields.climbingSince')
			->setType('date')
			->setAttribute('placeholder', 'fields.climbingSince');

		$form->addPassword('password', 'fields.password')
			->setAttribute('placeholder', 'fields.password');

		$user = $this->user;
		$form->setDefaults([
			'nick' => $user->getNick(),
			'firstName' => $user->getFirstName(),
			'lastName' => $user->getLastName(),
			'email' => $user->getEmail(),
			'phone' => $user->getPhone(),
			'weight' => $user->getWeight(),
			'height' => $user->getHeight(),
			'birthDate' => $user->getBirthDate() ? $user->getBirthDate()->format('d-m-Y') : '',
			'climbingSince' => $user->getClimbingSince() ? $user->getBirthDate()->format('d-m-Y'): '',
		]);

		if ($this->user->getId()) {
			$form->addSubmit('save', 'fields.edit');
		} else {
			$form->addSubmit('save', 'fields.add');
		}
	}


	/**
	 * @inheritdoc
	 */
	public function validateForm(Form $form, ArrayHash $values)
	{
		if ($this->userRepository->getResultByFilters(new DuplicateNick($this->user, $values->nick))) {
			$form['nick']->addError('errors.nick.duplicate');
		}

		if ($this->userRepository->getResultByFilters(new DuplicateEmail($this->user, $values->email))) {
			$form['email']->addError('errors.email.duplicate');
		}
	}


	/**
	 * @inheritdoc
	 */
	public function formSuccess(Form $form, ArrayHash $values)
	{
		$user = $this->user;
		$user->setNick($values->nick);
		$user->setFirstName($values->firstName);
		$user->setLastName($values->lastName);
		$user->setEmail($values->email);
		$user->setPhone($values->phone);
		$user->setWeight($values->weight);
		$user->setHeight($values->height);
		$user->setBirthDate(new DateTime($values->birthDate));
		$user->setClimbingSince(new DateTime($values->climbingSince));

		if ($values->password) {
			$user->setPassword(Passwords::hash($values->password));
		}

		$isNew = !$user->getId();

		$this->userRepository->save($user);

		if ($isNew) {
			$this->onCreate($user);
		} else {
			$this->onEdit($user);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getDomain()
	{
		return 'user.userForm';
	}
}
