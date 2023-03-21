<?php

declare(strict_types=1);

namespace Bluethinkinc\CancelOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{

    private const CANCEL_ORDER_REASON = 'cancel_order_reason';

    private const PRIMARY_KEY = 'id';

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::CANCEL_ORDER_REASON, self::PRIMARY_KEY);
    }
}
