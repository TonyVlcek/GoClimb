<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Console\Commands;

use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\Model\UserException;
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


	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
		parent::__construct('app:user:create');
	}


	protected function configure()
	{
		$this->setDescription('Creates new user')
			->addArgument('name', InputArgument::REQUIRED, 'The user\'s login');
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$name = $input->getArgument('name');

		/** @var QuestionHelper $helper */
		$helper = $this->getHelper('question');
		$question = new Question(sprintf('Password for user %s (default: <info>admin</info>):', $name), 'admin');
		$question->setHidden(TRUE);
		$question->setValidator(function ($password) {
			if (trim($password) === '') {
				return 'admin';
			}
			return $password;
		});

		$password = $helper->ask($input, $output, $question);

		try {
			$this->userRepository->createUser($name, $password);
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
