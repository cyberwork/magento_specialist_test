<?php
declare(strict_types=1);

namespace Suno\TesteTecnico\Model\ResourceModel\Signatures;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Suno\TesteTecnico\Model\Signatures as Model;
use Suno\TesteTecnico\Model\ResourceModel\Signatures as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}




