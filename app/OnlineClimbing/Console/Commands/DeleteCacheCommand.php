<?php
/**
 * @author Tomáš Blatný
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class DeleteCacheCommand extends Command
{

	private $appDir;

	public function __construct($appDir)
	{
		$this->appDir = $appDir;
		parent::__construct('app:cleanup');
	}


	protected function configure()
	{
		$this->setDescription('Delete nette cache');
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$ignored = array('.', '..');
		foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->appDir .'/../temp/cache')) as $filename => $fileinfo) {
			if(!in_array($fileinfo->getFilename(), $ignored)) {
				$output->writeln(" <fg=red>Removed: $filename</>");
				$output->setDecorated(true);
				if(is_dir($filename)) {
					@rmdir($filename);
				} else {
					@unlink($filename);
				}
			}
		}
		return 0;
	}

}
