<?php

namespace Vitre\PhpConsoleBundle\Drivers\ChromeLogger;

use Symfony\Component\DependencyInjection\ContainerAware;
use Vitre\PhpConsoleBundle\ConnectionInterface;
use Vitre\PhpConsoleBundle\AbstractConnection;

class Connection extends AbstractConnection implements ConnectionInterface
{

    //---

    public function connect()
    {
    }


    public function log()
    {
        $args = func_get_args();
        call_user_func_array('ChromePhp::log', $args);

        return $this;
    }

    public function warn()
    {
        $args = func_get_args();
        call_user_func_array('ChromePhp::warn', $args);

        return $this;
    }


}