<?php
declare(strict_types=1);

namespace App\Crawler;

use App\Crawler\Event\BeginEvent;
use App\Crawler\Event\FinishEvent;
use App\Events;
use App\Product\ProductRepository;
use App\Retailer\AmazonRetailer;
use App\Retailer\MediamarktRetailer;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\NoRecipient;
use Symfony\Component\Panther\Client;

final class Crawler
{
    public function __construct(
        private ProductRepository $productRepository,
        private AmazonRetailer $amazonRetailer,
        private MediamarktRetailer $mediamarktRetailer,
        private NotifierInterface $notifier,
        private LoggerInterface $logger,
        private EventDispatcherInterface $eventDispatcher,
        private Client $client
    ) {}

    public function crawl(): void
    {
        foreach ($this->productRepository->all() as $product) {
            $this->logger->info('Checking stock for product '. $product->getName());
            $this->eventDispatcher->dispatch(new BeginEvent($product), Events::CRAWLER_BEGIN);

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

            $this->eventDispatcher->dispatch(new FinishEvent($product, ...$checkResults), Events::CRAWLER_FINISH);
        }
    }
}