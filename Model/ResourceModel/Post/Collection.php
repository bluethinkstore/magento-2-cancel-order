<?php

declare(strict_types=1);

namespace Bluethinkinc\CancelOrder\Model\ResourceModel\Post;

use Bluethinkinc\CancelOrder\Model\Post;
use Bluethinkinc\CancelOrder\Model\ResourceModel\Post as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Post::class, ResourceModel::class);
    }
}
