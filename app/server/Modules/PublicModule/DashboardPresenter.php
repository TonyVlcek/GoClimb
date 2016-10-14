<?php

namespace GoClimb\Modules\PublicModule;

use GoClimb\UI\Forms\Form;
use Kdyby\Translation\ITranslator;
use Nette\InvalidStateException;
use Nette\Mail\Message;
use Nette\Mail\IMailer;


final class DashboardPresenter extends BasePublicPresenter
{

	/** @var IMailer */
	private $mailer;

	public function __construct(IMailer $mailer, ITranslator $translator)
	{
		parent::__construct();
		$this->mailer = $mailer;
		$this->translator = $translator;
	}


	protected function createComponentContactForm()
	{
		$form = new Form;
		$form->setTranslator($this->translator->domain('forms.' . 'public.contactForm'));
		$form->addText('name', 'name')
			->setAttribute('placeholder', 'fields.name')
			->addRule(Form::FILLED, 'errors.name.required');

		$form->addText('email', 'email')
			->setAttribute('placeholder', 'fields.email')
			->addRule(Form::FILLED, 'errors.email.required')
			->addRule(Form::EMAIL, 'errors.email.invalid');

		$form->addText('phone', 'phone')
			->setAttribute('placeholder', 'fields.phone');

		$form->addTextArea('text', 'message')
			->setAttribute('placeholder', 'fields.message')
			->addRule(Form::FILLED, 'errors.message.required');

		$form->addSubmit('submit', 'fields.send');

		$form->onSuccess[] = [$this, 'contactFormSubmitted'];
		return $form;
	}


	public function contactFormSubmitted(Form $form)
	{
		try {
			$this->sendMail($form->getValues());
			$this->flashMessageSuccess('contact.sent');
			$this->redirect('this');
		} catch (InvalidStateException $e) {
			$this->flashMessageSuccess('contact.error');
		}
	}


	private function sendMail($values)
	{
		$mail = new Message;
		$mail->setSubject('Nová zpráva z kontaktního formuláře');
		$mail->setFrom($values['email'], $values['name']);
		$mail->addTo('goclimb@email.cz', 'GoClimb');

		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/templates/email.latte');

		$template->name = $values['name'];
		$template->email = $values['email'];
		$template->text = $values['text'];

		$mail->setHtmlBody($template);
		$this->mailer->send($mail);
	}
}
