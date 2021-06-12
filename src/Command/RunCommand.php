<?php
declare(strict_types=1);

namespace App\Command;


use Amp\Loop;
use App\Events;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\Event;

class RunCommand extends Command
{
	public function __construct(
	    private EventDispatcherInterface $eventDispatcher
	)
	{
		parent::__construct();
	}

	protected function configure()
	{
		$this
			->setName('run')
			->setDescription('Run the application');
	}

	/**
	 * @throws \Exception
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
	    Loop::run(function () {
	        $this->eventDispatcher->dispatch(new Event(), Events::LOOP_START);

	        Loop::disable(Loop::onSignal(\SIGINT, function (string $watcherId) {
                $this->eventDispatcher->dispatch(new Event(), Events::LOOP_START);
            }));
        });
	    return Command::SUCCESS;
	}
}