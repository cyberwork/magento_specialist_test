<?php
declare(strict_types=1);

namespace Suno\TesteTecnico\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Signatures extends AbstractDb
{
    /** @var string Main table name */
    const MAIN_TABLE = 'signatures';

    /** @var string Main table primary key field name */
    const ID_FIELD_NAME = 'signature_id';

    protected function _construct(): void
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}

