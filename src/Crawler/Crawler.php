<?php
declare(strict_types=1);

namespace App\Crawler;

use Amp\Loop;
use App\Events;
use App\Product\ProductRepository;
use App\Retailer\AmazonRetailer;
use App\Retailer\MediamarktRetailer;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\NoRecipient;
use Symfony\Component\Panther\Client;

#[AsEventListener(Events::LOOP_START, 'onLoopStart')]
#[AsEventListener(Events::LOOP_CANCEL, 'onLoopCancel')]
final class Crawler
{
    private ?string $watcher = null;

    public function __construct(
        private ProductRepository $productRepository,
        private AmazonRetailer $amazonRetailer,
        private MediamarktRetailer $mediamarktRetailer,
        private NotifierInterface $notifier,
        private LoggerInterface $logger,
        private Client $client
    ) {}

    public function crawl(): void
    {
        foreach ($this->productRepository->all() as $product) {
            $this->logger->info('Checking stock for product '. $product->getName());

            $checkResults = [
                $this->amazonRetailer->checkStock($this->client, $product),
                $this->mediamarktRetailer->checkStock($this->client, $product),
            ];

            foreach($checkResults as $checkResult)
            {
                if ($checkResult->isInStock())
                {
                    $this->logger->info('Product '. $product->getName() .' is in stock!');
                    $notification = (new Notification)
                        ->subject(sprintf('New Stock! "%s" is in stock again. (%s)-Link: "%s"', $product->getName(), $checkResult->getRetailer()->identifier(), $checkResult->getShopUrl()))
                        ->channels(['chat/discord']);

                    $this->notifier->send(
                        $notification,
                        new NoRecipient()
                    );
                }
            }
        }
    }


    public function onLoopStart(): void
    {
        Loop::defer([$this, 'crawl']);
        $this->watcher = Loop::repeat(30 * 1000, [$this, 'crawl']);
    }

    public function onLoopCancel(): void
    {
        if (!$this->watcher) {
            return;
        }

        $this->client->quit();
        Loop::cancel($this->watcher);
    }
}