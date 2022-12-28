<?php
declare(strict_types=1);

namespace Suno\TesteTecnico\Model;

use Magento\Framework\Model\AbstractModel;

class Signatures extends AbstractModel
{
    protected function _construct(): void
    {
        $this->_init(ResourceModel\Signatures::class);
    }
}
