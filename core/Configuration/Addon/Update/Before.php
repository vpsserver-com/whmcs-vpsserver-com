<?php

namespace ModulesGarden\Servers\VpsServer\Core\Configuration\Addon\Update;

use ModulesGarden\Servers\VpsServer\Core\Configuration\Addon\AbstractBefore;

/**
 * Description of Before
 *
 * @author Rafał Ossowski <rafal.os@modulesgarden.com>
 */
class Before extends AbstractBefore
{

    /**
     * @return array
     */
    public function execute($version)
    {
        return [];
    }
}
