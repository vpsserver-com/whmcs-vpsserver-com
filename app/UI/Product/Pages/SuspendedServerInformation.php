<?php

namespace ModulesGarden\Servers\VpsServer\App\UI\Product\Pages;

use ModulesGarden\Servers\VpsServer\Core\Helper\Lang;
use ModulesGarden\Servers\VpsServer\Core\UI\Interfaces\AdminArea;
use ModulesGarden\Servers\VpsServer\Core\UI\Builder\BaseContainer;
use ModulesGarden\Servers\VpsServer\Core\UI\Interfaces\ClientArea;

class SuspendedServerInformation extends BaseContainer implements ClientArea, AdminArea
{
    protected $id          = 'info';
    protected $title       = 'info';
    protected $searchable  = false;

    public function initContent()
    {
        $this->customTplVars['serverinfo'] = Lang::getInstance()->T('suspendedServerAccess');
    }
}
