<?php
declare(strict_types=1);

namespace App\HttpServer\RequestHandler;


use Amp\Http\Server\Request;
use Amp\Http\Server\RequestHandler;
use Amp\Http\Server\Response;
use Amp\Promise;
use App\Kernel;
use Psr\Log\LoggerInterface;
use function Amp\call;

final class SymfonyRequestHandler implements RequestHandler
{
    public function __construct(
        private Kernel $kernel,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function handleRequest(Request $request): Promise
    {
        return call(function () use ($request) {
            $symfonyRequest = \Symfony\Component\HttpFoundation\Request::create(
                (string)$request->getUri(),
                $request->getMethod(),
                $request->getAttributes(),
                $request->getCookies()
            );

            try {
                $symfonyResponse = $this->kernel->handle($symfonyRequest);
            } catch (\Throwable $e) {
                $this->logger->alert(sprintf('Unhandled exception "%s"', $e->getMessage()));
                throw $e;
            }

            return new Response(
                $symfonyResponse->getStatusCode(),
                $symfonyResponse->headers->allPreserveCase(),
                $symfonyResponse->getContent(),
            );
        });
    }
}