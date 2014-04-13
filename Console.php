<?php

namespace Vitre\PhpConsoleBundle;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\Container;

class Console extends ContainerAware
{
    protected $connection = false;

    private $enabled = false;

    private $driver = 'php_console';

    //---

    public function __construct($container)
    {

        $this->setContainer($container);

        $this->initEnabled();
        $this->initDriver();

        if ($this->getEnabled()) {

            $this->connect();

        }

        return $this;
    }

    public function initEnabled()
    {
        $this->setEnabled($this->container->getParameter('vitre_php_console.enabled'));
    }

    public function initDriver()
    {
        $this->driver = $this->container->getParameter('vitre_php_console.driver');
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
        if ($this->connection === false) {

            // PHP console driver
            $driverName = Container::camelize($this->driver);
            $class = __NAMESPACE__ . '\\Drivers\\' . $driverName . '\\Connection';
            if (class_exists($class)) {
                $this->connection = new $class($this);
                $this->connection->connect();

                return $this->connection;
            } else {
                trigger_error('PHP console driver "' . $class . '" not exists.', \E_USER_ERROR);
            }
        }

        return false;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function log()
    {
        if ($this->getEnabled()) {
            return call_user_func_array([$this->getConnection(), 'log'], func_get_args());
        }

        return false;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}