<?php

namespace Vitre\PhpConsoleBundle;

use Symfony\Component\DependencyInjection\ContainerAware;

class Console extends ContainerAware
{
    protected $connection = false;

    private $enabled = false;

    //---

    public function __construct($container)
    {

        $this->setContainer($container);

        $this->initEnabled();

        if ($this->getEnabled()) {

            $this->connect();

        }

        return $this;
    }

    public function initEnabled()
    {
        $this->setEnabled($this->container->getParameter('vitre_php_console.enabled'));
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
            $this->connection = new Drivers\PhpConsole\Connection($this);
            $this->connection->connect();
        }
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