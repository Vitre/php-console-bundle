<?php

namespace Vitre\PhpConsoleBundle\Drivers\ChromeLogger;

use Vitre\PhpConsoleBundle\DriverInterface;
use Vitre\PhpConsoleBundle\AbstractDriver;

class Driver extends AbstractDriver implements DriverInterface
{

    protected $_instance;

    //---

    public function connect()
    {
        $this->_instance = $this->_getInstance();
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

    public function error()
    {
        $args = func_get_args();
        call_user_func_array('ChromePhp::error', $args);

        return $this;
    }

    public function info()
    {
        $args = func_get_args();
        call_user_func_array('ChromePhp::info', $args);

        return $this;
    }

    public function group()
    {
        $args = func_get_args();
        call_user_func_array('ChromePhp::group', $args);

        return $this;
    }

    public function groupCollapsed()
    {
        $args = func_get_args();
        call_user_func_array('ChromePhp::groupCollapsed', $args);

        return $this;
    }

    public function groupEnd()
    {
        $args = func_get_args();
        call_user_func_array('ChromePhp::groupEnd', $args);

        return $this;
    }

    public function table()
    {
        $args = func_get_args();
        call_user_func_array('ChromePhp::table', $args);

        return $this;
    }

    public function getInstance()
    {
        return $this->_instance;
    }

    public function _getInstance()
    {
        return \ChromePhp::getInstance();
    }


}