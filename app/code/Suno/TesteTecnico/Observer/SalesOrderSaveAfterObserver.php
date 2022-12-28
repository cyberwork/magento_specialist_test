<?php

namespace Suno\TesteTecnico\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

use Suno\TesteTecnico\Model\SignaturesFactory;
use Suno\TesteTecnico\Model\ResourceModel\Signatures;
use Magento\Backend\Model\Auth\SessionFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Suno\TesteTecnico\Logger\Logger;

/**
 * Observes the `sales_order_save_after` event.
 */
class SalesOrderSaveAfterObserver implements ObserverInterface
{
    public function __construct(
        protected SignaturesFactory $signaturesFactory,
        protected Signatures $resource,
        protected SessionFactory $userSessionFactory,
        protected TimezoneInterface $timezoneInterface,
        protected Logger $logger
    ) {

    }
    /**
     * Observer for sales_order_save_after.
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer): void
    {
        try {
            $order = $observer->getEvent()->getOrder();
            $customerId = $order->getCustomerId();

            foreach($order->getAllItems() as $item)
            {
                if (!$item->isDeleted() && !$item->getParentItem()) {
                    $productId = $item->getProductId();
                    $productSku = $item->getSku();
                    $signaturesModel = $this->signaturesFactory->create()->setData([
                        'customer_id' => $customerId,
                        'product_id' => $productId,
                        'product_sku' => $productSku,
                        'status' => true,
                        'valid_at' => $this->timezoneInterface->date()->modify('+1 month')->getTimestamp()
                    ]);
                    $this->resource->save($signaturesModel);
                }
            }
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
    }
}
