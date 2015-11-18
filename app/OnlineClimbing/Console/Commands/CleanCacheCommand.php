<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Console\Commands;

use OnlineClimbing\Console\CacheCleaner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class CleanCacheCommand extends Command
{

	protected function configure()
	{
		$this->setName('app:cache:clean')
			->setAliases([
				'app:cache:clear',
				'app:cache:purge',
			])
			->setDescription('Cleans application cache (including test cache).');
	}


	public function run(InputInterface $input, OutputInterface $output)
	{
		foreach (CacheCleaner::cleanCache() as $path => $result) {
			$this->printResult($output, $path, $result);
		}
	}


	private function printResult(OutputInterface $output, $path, $result)
	{
		$dirTag = $result['dirsToRemove'] === $result['dirsRemoved'] ? 'info' : 'error';
		$fileTag = $result['filesToRemove'] === $result['filesRemoved'] ? 'info' : 'error';
		$output->writeln(sprintf('%s: <%s>Removed %d/%d directories</%s>', $path, $dirTag, $result['dirsToRemove'], $result['dirsRemoved'], $dirTag));
		$output->writeln(sprintf('%s: <%s>Removed %d/%d files</%s>', $path, $fileTag, $result['filesToRemove'], $result['filesRemoved'], $fileTag));
	}

}
