<?php
declare(strict_types=1);

namespace App\Command;


use App\Product\Asin;
use App\Product\Product;
use App\Product\ProductRepository;
use App\Retailer\AmazonRetailer;
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
		private NotifierInterface $notifier
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

	protected function execute(InputInterface $input, OutputInterface $output)
	{
	    foreach ($this->productRepository->all() as $product) {
            if (($inStock = $this->amazonRetailer->checkStock($product))->isInStock()) {
                $notification = (new Notification)
                    ->subject(sprintf('New Stock! "%s" is in stock again. Link: "%s"', $product->getName(), $inStock->getShopUrl()))
                    ->channels(['chat/discord']);

                $this->notifier->send(
                    $notification,
                    new NoRecipient()
                );
            }
        }

		return 0;
	}
}