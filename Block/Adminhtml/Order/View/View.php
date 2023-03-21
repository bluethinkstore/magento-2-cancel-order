<?php

declare(strict_types=1);

namespace Bluethinkinc\CancelOrder\Block\Adminhtml\Order\View;

use Bluethinkinc\CancelOrder\Model\PostFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Backend\Block\Template;

class View extends Template
{
    private const ORDER_ID = 'order_id';
    
    private const PROCESSING = 'processing';
    
    private const CANCELLED = 'cancelled';
    
    private const REJECTED = 'rejected';

    private const ACCEPT = 'Accept';

    private const REJECT = 'Reject';

    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @param Context $context
     * @param PostFactory $postFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        PostFactory $postFactory,
        OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->postFactory = $postFactory;
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get order Id form parameter
     *
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->getRequest()->getParam(self::ORDER_ID);
    }

    /**
     * Get reason of cancel order
     *
     * @param string $orderId
     * @return mixed
     */
    public function getReason($orderId)
    {
        return $this->postFactory->create()->load($orderId, self::ORDER_ID);
    }

    /**
     * Check order cancel
     *
     * @param string $reason
     * @return bool
     */
    public function isOrderCancel($reason)
    {

        if ($reason->getOrderStatusByCustomer() === self::PROCESSING
        || $reason->getOrderStatusByCustomer() === self::CANCELLED
        || $reason->getOrderStatusByCustomer() === self::REJECTED
        ) {
            return true;
        }
        return false;
    }

    /**
     * Get order status
     *
     * @param string $reason
     * @return mixed
     */
    public function getOrderStatus($reason)
    {
        return $reason->getOrderStatusByCustomer();
    }

    /**
     * Get form key
     *
     * @return string
     * @throws LocalizedException
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    /**
     * Accept cancel order url
     *
     * @param string $reason
     * @param string $label
     * @return string
     */
    public function acceptCancelOrderUrl($reason, $label = self::ACCEPT)
    {
        $url = $this->getUrl('cancelorder/index/index', [self::ORDER_ID => $reason->getOrderId()]);
        return '<a href="' . $this->escapeUrl($url) . '">' . $this->escapeHtml($label) . '</a>';
    }

    /**
     * Deny cancel order url
     *
     * @param string $reason
     * @param string $label
     * @return string
     */
    public function denyCancelOrderUrl($reason, $label = self::REJECT)
    {
        $url = $this->getUrl('cancelorder/index/reject', [self::ORDER_ID => $reason->getOrderId()]);
        return '<a href="' . $this->escapeUrl($url) . '">' . $this->escapeHtml($label) . '</a>';
    }

    /**
     * Get status of order
     *
     * @return string|null
     */
    public function getStatusOfOrder()
    {
        $order = $this->orderRepository->get($this->getOrderId());
        return $order->getState();
    }
}
