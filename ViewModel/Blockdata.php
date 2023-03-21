<?php

declare(strict_types=1);

namespace Bluethinkinc\CancelOrder\ViewModel;

use Bluethinkinc\CancelOrder\Block\Adminhtml\Order\View\View;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Block\Order\History;
use Magento\Sales\Helper\Reorder;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\UrlInterface;
use Bluethinkinc\CancelOrder\Model\Config\Provider;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Blockdata implements ArgumentInterface
{
        
    private const ORDER_ID = 'order_id';

    /**
     * @var View
     */
    protected $blockData;

    /**
     * @var PostHelper
     */
    protected $postHelper;

    /**
     * @var Reorder
     */
    protected $reorder;

    /**
     * @var History
     */
    protected $history;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     *
     * @var Provider
     */
    protected $provider;

    /**
     * @param View $blockData
     * @param Reorder $reorder
     * @param History $history
     * @param PostHelper $postHelper
     * @param UrlInterface $urlBuilder
     * @param Provider $provider
     */
    public function __construct(
        View $blockData,
        Reorder $reorder,
        History $history,
        PostHelper $postHelper,
        UrlInterface $urlBuilder,
        Provider $provider
    ) {
        $this->reorder = $reorder;
        $this->history = $history;
        $this->blockData = $blockData;
        $this->postHelper = $postHelper;
        $this->urlBuilder = $urlBuilder;
        $this->provider = $provider;
    }

    /**
     * Get customer by id
     *
     * @param string $orderId
     * @return bool
     */
    public function isOrderCancel($orderId)
    {
        $reason = $this->blockData->getReason($orderId);
        return $this->blockData->isOrderCancel($reason);
    }

    /**
     * Check reorder or not
     *
     * @param string $orderId
     * @return bool
     */
    public function canReorder($orderId)
    {
        return $this->reorder->canReorder($orderId);
    }

    /**
     * Get Post Data
     *
     * @param string $reOrderUrl
     * @return string
     */
    public function getPostData($reOrderUrl)
    {
        return $this->postHelper->getPostData($reOrderUrl);
    }

    /**
     * Get sales order url
     *
     * @param string $order
     * @return string
     */
    public function getSalesOrderUrl($order)
    {
        return $this->urlBuilder->getUrl('sales/order/view', [self::ORDER_ID => $order->getId()]);
    }

    /**
     * Get questions form config
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function getQuestions()
    {
         return $this->provider->getQuestions();
    }

    /**
     * Get controller url
     *
     * @param string $order
     * @return string
     */
    public function getUrl($order)
    {
         return $this->urlBuilder->getUrl('cancelorder/index', [self::ORDER_ID => $order->getId()]);
    }
}
