<?php

declare(strict_types=1);

namespace Bluethinkinc\CancelOrder\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Bluethinkinc\CancelOrder\Model\PostFactory;

class Reject extends Action
{
    
    private const ORDER_ID = 'order_id';

    private const REJECTED = 'rejected';

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @param Context $context
     * @param PostFactory $postFactory
     */
    public function __construct(
        Context $context,
        PostFactory $postFactory
    ) {
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $orderId = $this->getRequest()->getParam(self::ORDER_ID);
        $model = $this->postFactory->create()->load($orderId, self::ORDER_ID);
        $model->setOrderStatusByCustomer(self::REJECTED)->save();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }

    /**
     * For ACL
     *
     * @return true
     */
    protected function _isAllowed()
    {
        return true;
    }
}
