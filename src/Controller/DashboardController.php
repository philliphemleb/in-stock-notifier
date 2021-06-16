<?php

namespace App\Controller;

use App\Crawler\Event\FinishEvent;
use App\Retailer\StockCheckResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private array $crawlerRuns = [];

    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        return $this->json(array_map(function ($run) {
            return [
                'timestamp' => $run['timestamp']->format(\DateTimeInterface::ATOM),
                'product'   => $run['product']->getName(),
                'stock'     => array_map(function (StockCheckResult $result) {
                    return [
                        'available' => $result->isInStock(),
                        'retailer' => $result->getRetailer()->identifier(),
                        'screenshot' => $result->getScreenshot()?->getPathname()
                    ];
                }, $run['stock_check_results'])
            ];
        }, $this->crawlerRuns));
    }

    public function onCrawlerFinish(FinishEvent $event): void
    {
        $this->crawlerRuns[] = [
            'timestamp' => new \DateTimeImmutable(),
            'product' => $event->getProduct(),
            'stock_check_results' => $event->getStockCheckResults()
        ];
    }
}
