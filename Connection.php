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

    public function __construct($container)
    {

        $this->setContainer($container);

        if ($this->container->getParameter('vitre_php_console.enabled')) {
            $this->connect();
            PhpConsole\Helper::register();
        }
    }

    protected function configure()
    {
        $this->connection->setSourcesBasePath($this->container->getParameter('vitre_php_console.source_base_path'));

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

    protected function initSession()
    {
        $file = $this->container->get('kernel')->getRootDir() . '/tmp/pc.data';
        Connector::setPostponeStorage(new \PhpConsole\Storage\File($file));
    }

    public function connect()
    {
        if ($this->connection === false) {

            $this->initSession();

            $this->connection = Connector::getInstance();

            $this->configure();

            $this->initHandler();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function log() {
        if ($this->container->getParameter('vitre_php_console.enabled')) {
            call_user_func_array([$this->connection->getDebugDispatcher(), 'dispatchDebug'], func_get_args());
        }

        return $this;
    }


}