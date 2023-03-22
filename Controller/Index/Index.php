<?php

declare(strict_types=1);

namespace Bluethinkinc\CancelOrder\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Bluethinkinc\CancelOrder\Model\PostFactory;
use Magento\Framework\App\RequestInterface;

class Index implements HttpPostActionInterface
{

    private const ORDER_ID = 'orderId';

    private const REASON = 'reason';
        
    private const PROCESSING = 'processing';

    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @param PageFactory $pageFactory
     * @param PostFactory $postFactory
     * @param RequestInterface $request
     */
    public function __construct(
        PageFactory $pageFactory,
        PostFactory $postFactory,
        RequestInterface $request
    ) {
        $this->_pageFactory = $pageFactory;
        $this->request = $request;
        $this->postFactory = $postFactory;
    }

    /**
     * Execute controller
     *
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $cancelData = $this->request->getParams();
        $orderId = $cancelData[self::ORDER_ID];
        $question = $cancelData[self::REASON];
        $model = $this->postFactory->create();
        $model->setOrderId($orderId);
        $model->setReason($question);
        $model->setOrderStatusByCustomer(self::PROCESSING)->save();
        return $this->_pageFactory->create();
    }
}
