<?php

namespace Vitre\PhpConsoleBundle;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Console implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected $connection = false;

    private $enabled = false;

    private $driver = false;

    //---

    public function __construct($container)
    {

        $this->setContainer($container);

        $this->initEnabled();

        if ($this->enabled()) {

            $this->connect();

        }

        return $this;
    }

    public function initEnabled()
    {
        $enabled = $this->container->getParameter('vitre_php_console.enabled') && $this->isDev();
        $this->setEnabled($enabled);
    }

    public function isDev()
    {
        return $this->container->get('kernel')->getEnvironment() === 'dev';
    }

    public function enabled()
    {
        return $this->getEnabled();
    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($value)
    {
        $this->enabled = $value;

        return $this;
    }

    public function connect()
    {
        if ($this->driver === false) {

            $this->initDriver();

        }

        return $this;
    }

    protected function initDriver()
    {
        $this->driver = $this->container->getParameter('vitre_php_console.driver');

        $driverName = Container::camelize($this->driver);
        $class = __NAMESPACE__ . '\\Drivers\\' . $driverName . '\\Driver';

        if (class_exists($class)) {

            $this->driver = new $class($this);
            $this->driver->connect();

            return $this->driver;

        } else {
            trigger_error('PHP console driver "' . $class . '" not exists.', \E_USER_ERROR);
        }
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function warn()
    {
        if ($this->enabled()) {
            return call_user_func_array([$this->getDriver(), 'warn'], func_get_args());
        }

        return false;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function table()
    {
        if ($this->enabled()) {
            return call_user_func_array([$this->getDriver(), 'table'], func_get_args());
        }

        return false;
    }

    public function info()
    {
        if ($this->enabled()) {
            return call_user_func_array([$this->getDriver(), 'info'], func_get_args());
        }

        return false;
    }

    public function query($query, $name)
    {
        if ($this->enabled()) {
            $this->group($name);
            $this->log('[DQL]', $query->getDQL());
            $this->log('[SQL]', $query->getSQL());
            $this->groupEnd();
        }
    }

    public function group()
    {
        if ($this->enabled()) {
            return call_user_func_array([$this->getDriver(), 'group'], func_get_args());
        }

        return false;
    }

    public function log()
    {
        if ($this->enabled()) {
            return call_user_func_array([$this->getDriver(), 'log'], func_get_args());
        }

        return false;
    }

    public function groupEnd()
    {
        if ($this->enabled()) {
            return call_user_func_array([$this->getDriver(), 'groupEnd'], func_get_args());
        }

        return false;
    }

}
