<?php
namespace Suno\TesteTecnico\Controller\Adminhtml\Request;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\App\Response\RedirectInterface;
use Suno\TesteTecnico\Model\SignaturesFactory;
use Suno\TesteTecnico\Model\ResourceModel\Signatures\CollectionFactory;
use Suno\TesteTecnico\Model\ResourceModel\Signatures;

class MassDisable extends Action
{


    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param SignaturesFactory $signaturesFactory
     * @param Signatures $resource
     * @param RedirectInterface $redirector
     */
    public function __construct(
        Action\Context               $context,
        protected Filter             $filter,
        protected CollectionFactory  $collectionFactory,
        protected SignaturesFactory  $signaturesFactory,
        protected Signatures         $resource,
        protected RedirectInterface  $redirector
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $recordsDisabled = 0;
        foreach ($collection->getItems() as $row) {
            $signaturesModel = $this->signaturesFactory->create();
            $signaturesModel->setId($row->getData('signature_id'));
            $signaturesModel->setData('status', 0);
            $this->resource->save($signaturesModel);
            $recordsDisabled++;
        }

        if ($recordsDisabled) {
            $this->messageManager->addSuccessMessage(
                __('%1 registro(s) desabilitados.', $recordsDisabled)
            );
        }

        return $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT)
            ->setPath($this->redirector->getRefererUrl());
    }
}
