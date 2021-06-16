<?php
declare(strict_types=1);

namespace App\Command;


use App\Crawler\Crawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlCommand extends Command
{
	public function __construct(
	    private Crawler $crawler
	)
	{
		parent::__construct();
	}

	protected function configure()
	{
		$this
			->setName('crawl')
			->setDescription('Run the crawler');
	}

	/**
	 * @throws \Exception
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
	    $this->crawler->crawl();
	    return Command::SUCCESS;
	}
}