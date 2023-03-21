<?php

declare(strict_types=1);

namespace Bluethinkinc\CancelOrder\Model;

use Bluethinkinc\CancelOrder\Model\ResourceModel\Post as ResourceModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Post extends AbstractModel implements IdentityInterface
{
    private const CACHE_TAG = 'cancel_order_reason';

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Get Identities
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
