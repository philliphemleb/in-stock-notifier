<?php
declare(strict_types=1);

namespace App\HttpServer;


use Amp\Http\Server\HttpServer as AmpHttpServer;
use Amp\Loop;
use Amp\Socket\Server;
use App\Events;
use App\HttpServer\RequestHandler\SymfonyRequestHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(Events::LOOP_START, 'onLoopStart')]
#[AsEventListener(Events::LOOP_CANCEL, 'onLoopCancel')]
final class HttpServer
{
    private AmpHttpServer $server;
    private ?string $watcher = null;

    public function __construct(
        private SymfonyRequestHandler $handler,
        private LoggerInterface $logger
    ) {
        $this->server = new AmpHttpServer(
            [
                Server::listen('0.0.0.0:8000'),
                Server::listen('[::]:8000'),
            ],
            $this->handler,
            $this->logger,
        );
    }

    public function onLoopStart(): void
    {
        $this->logger->alert('[HttpServer] Start listening on :8000');
        $this->watcher = Loop::defer(fn() => yield $this->server->start());
    }

    public function onLoopCancel(): void
    {
        if (!$this->watcher) {
            return;
        }

        $this->logger->alert('[HttpServer] Stop listening');
        $this->server->stop();
        Loop::disable($this->watcher);
        $this->watcher = null;
    }
}