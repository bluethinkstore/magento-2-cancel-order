<?php

declare(strict_types=1);

namespace Bluethinkinc\CancelOrder\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Bluethinkinc\CancelOrder\Model\PostFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Framework\Exception\LocalizedException;

class Index extends Action
{
    
    private const ORDER_ID = 'order_id';
    
    private const CANCELLED = 'cancelled';

    /**
     * @var OrderManagementInterface
     */
    private $orderManagement;

    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @param Context $context
     * @param OrderManagementInterface $orderManagement
     * @param PostFactory $postFactory
     */
    public function __construct(
        Context $context,
        OrderManagementInterface $orderManagement,
        PostFactory $postFactory
    ) {
        $this->orderManagement = $orderManagement;
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
        try {
            $this->orderManagement->cancel($orderId);
            $this->messageManager->addSuccessMessage(__('You cancelled the order.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $model = $this->postFactory->create()->load($orderId, self::ORDER_ID);
        $model->setOrderStatusByCustomer(self::CANCELLED)->save();
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
