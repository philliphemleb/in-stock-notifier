<?php
declare(strict_types=1);

namespace App\Command;


use App\Product\ProductRepository;
use App\Retailer\AmazonRetailer;
use App\Retailer\MediamarktRetailer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\NoRecipient;

class RunCommand extends Command
{
	public function __construct(
	    private ProductRepository $productRepository,
		private AmazonRetailer $amazonRetailer,
		private MediamarktRetailer $mediamarktRetailer,
		private NotifierInterface $notifier,
        private LoggerInterface $logger
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
	    foreach ($this->productRepository->all() as $product) {
	        $this->logger->info('Checking stock for product '. $product->getName());

	        $checkResults = [
		        $this->amazonRetailer->checkStock($product),
		        $this->mediamarktRetailer->checkStock($product),
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

		return 0;
	}
}