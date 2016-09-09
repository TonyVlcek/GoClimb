<?php

namespace GoClimb\Console\Commands;

use GoClimb\Model\Facades\AclFacade;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\UserException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;


class CreateUserCommand extends Command
{

	/** @var UserRepository */
	private $userRepository;

	/** @var AclFacade */
	private $aclFacade;


	public function __construct(UserRepository $userRepository, AclFacade $aclFacade)
	{
		$this->userRepository = $userRepository;
		$this->aclFacade = $aclFacade;
		parent::__construct('app:user:create');
	}


	protected function configure()
	{
		$this->setDescription('Creates new user with global owner role.')
			->addArgument('email', InputArgument::REQUIRED, 'The user\'s email');
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$email = $input->getArgument('email');

		/** @var QuestionHelper $helper */
		$helper = $this->getHelper('question');
		$question = new Question(sprintf('Password for user %s (default: <info>admin</info>):', $email), 'admin');
		$question->setHidden(TRUE);
		$question->setValidator(function ($password) {
			if (trim($password) === '') {
				return 'admin';
			}
			return $password;
		});

		$password = $helper->ask($input, $output, $question);

		try {
			$user = $this->userRepository->createUser($email, $password);
			$this->aclFacade->setGlobalOwner($user);
		} catch (UserException $e) {
			if ($e->getCode() === UserException::DUPLICATE_NAME) {
				$output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
			} else {
				throw $e;
			}
			return $e->getCode();
		}
		$output->writeln('<info>User created</info>');
		return 0;
	}

}
