<?php

namespace Suno\TesteTecnico\Controller\Adminhtml\Request;

use Suno\TesteTecnico\Model\SignaturesFactory;
use Suno\TesteTecnico\Model\ResourceModel\Signatures;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Eav\Api\AttributeRepositoryInterface;

use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

/**
 *
 */
class Disable extends Action
{

    /**
     * @param Context $context
     * @param Signatures $resource
     * @param SignaturesFactory $productPriceChangeRequestFactory
     * @param RedirectInterface $redirector
     */
    public function __construct(
        Context                       $context,
        protected Signatures          $resource,
        protected SignaturesFactory   $signaturesFactory,
        protected RedirectInterface   $redirector
    ) {
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        try {
            if ($id = $this->_request->getParam("id")) {
                $signaturesModel = $this->signaturesFactory->create();
                $signaturesModel->setId($id);
                $signaturesModel->setData('status', 0);
                $this->resource->save($signaturesModel);

                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
                return $this->resultFactory
                    ->create(ResultFactory::TYPE_REDIRECT)
                    ->setPath($this->redirector->getRefererUrl());
            } else {
                $this->messageManager->addErrorMessage(__("Data not found."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("We can\'t submit your request, Please try again."));
        }
    }
}
