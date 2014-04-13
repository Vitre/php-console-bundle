<?php

namespace Vitre\PhpConsoleBundle;

use PhpConsole;
use PhpConsole\Connector;
use PhpConsole\Handler;
use Symfony\Component\DependencyInjection\ContainerAware;

class Connection extends ContainerAware
{

    protected $connection = false;

    protected $handler = false;

    private $enabled = false;

    //---

    public function __construct($container)
    {

        $this->setContainer($container);

        $this->initEnabled();

        if ($this->getEnabled()) {

            $this->connect();

            PhpConsole\Helper::register();
        }
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
        if ($this->getEnabled() && ($this->connection === false)) {

            $this->initSession();

            $this->connection = Connector::getInstance();

            $this->configure();

            $this->initHandler();
        }
    }

    protected function initSession()
    {
        $root = $this->initTmpDir();
        if ($root) {
            $file = $root . '/vitre_php_console.data';
            Connector::setPostponeStorage(new \PhpConsole\Storage\File($file));
        }
    }

    protected function initTmpDir()
    {
        $ok = false;
        $root = $this->container->get('kernel')->getRootDir() . '/tmp';
        if (!is_dir($root)) {
            $ok = mkdir($root);
        }
        if ($ok) {
            return $root;
        } else {
            return false;
        }
    }

    protected function configure()
    {
        $this->connection->setSourcesBasePath($this->container->getParameter('vitre_php_console.source_base_path'));
        if ($this->container->getParameter('vitre_php_console.ssl_only')) {
            $this->connection->enableSslOnlyMode($this->container->getParameter('vitre_php_console.ssl_only'));
        }
        if ($this->container->getParameter('vitre_php_console.encoding')) {
            $this->connection->setServerEncoding($this->container->getParameter('vitre_php_console.encoding'));
        }
        if ($this->container->getParameter('vitre_php_console.password')) {
            $this->connection->setPassword($this->container->getParameter('vitre_php_console.password'), true);
        }
        if ($this->container->getParameter('vitre_php_console.ip')) {
            $this->connection->setAllowedIpMasks($this->container->getParameter('vitre_php_console.ip'));
        }
        if ($this->container->getParameter('vitre_php_console.detect_trace_and_source')) {
            $this->connection->getDebugDispatcher()->detectTraceAndSource = $this->container->getParameter('vitre_php_console.detect_trace_and_source');
        }
    }

    protected function initHandler()
    {
        $this->handler = Handler::getInstance();
        $this->handler->setHandleExceptions($this->container->getParameter('vitre_php_console.handle.exceptions')); // disable exceptions handling
        $this->handler->setHandleErrors($this->container->getParameter('vitre_php_console.handle.errors')); // disable errors handling
        $this->handler->setCallOldHandlers($this->container->getParameter('vitre_php_console.handle.forward')); // disable passing errors & exceptions to prviously defined handlers
        $this->handler->start();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function log()
    {
        $args = func_get_args();

        if ($this->getEnabled()) {
            call_user_func_array([$this->connection->getDebugDispatcher(), 'dispatchDebug'], $args);
        }

        return $this;
    }


}