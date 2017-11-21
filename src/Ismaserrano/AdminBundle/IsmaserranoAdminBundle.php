<?php

namespace Ismaserrano\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * KunstmaanAdminBundle
 */
class IsmaserranoAdminBundle extends Bundle
{

    /**
     * @return string The Bundle parent name it overrides or null if no parent
     */
    public function getParent()
    {
        return 'KunstmaanAdminBundle';
    }
}
