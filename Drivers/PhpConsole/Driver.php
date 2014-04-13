<?php

namespace Vitre\PhpConsoleBundle\Drivers\PhpConsole;

use PhpConsole;
use PhpConsole\Connector;
use PhpConsole\Handler;
use Vitre\PhpConsoleBundle\DriverInterface;
use Vitre\PhpConsoleBundle\AbstractDriver;

class Driver extends AbstractDriver implements DriverInterface
{

    protected $connection = false;

    protected $handler = false;

    protected $console;

    //---

    public function __construct($console)
    {
        $this->console = $console;

        return $this;
    }

    public function connect()
    {
        if ($this->connection === false) {

            $this->initSession();

            $this->connection = Connector::getInstance();

            $this->configure();

            $this->initHandler();

            PhpConsole\Helper::register();
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
        $root = $this->console->getContainer()->get('kernel')->getRootDir() . '/tmp';
        $ok = is_dir($root);
        if (!$ok) {
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
        $this->connection->setSourcesBasePath($this->console->getContainer()->getParameter('vitre_php_console.source_base_path'));
        if ($this->console->getContainer()->getParameter('vitre_php_console.ssl_only')) {
            $this->connection->enableSslOnlyMode($this->console->getContainer()->getParameter('vitre_php_console.ssl_only'));
        }
        if ($this->console->getContainer()->getParameter('vitre_php_console.encoding')) {
            $this->connection->setServerEncoding($this->console->getContainer()->getParameter('vitre_php_console.encoding'));
        }
        if ($this->console->getContainer()->getParameter('vitre_php_console.password')) {
            $this->connection->setPassword($this->console->getContainer()->getParameter('vitre_php_console.password'), true);
        }
        if ($this->console->getContainer()->getParameter('vitre_php_console.ip')) {
            $this->connection->setAllowedIpMasks($this->console->getContainer()->getParameter('vitre_php_console.ip'));
        }
        if ($this->console->getContainer()->getParameter('vitre_php_console.detect_trace_and_source')) {
            $this->connection->getDebugDispatcher()->detectTraceAndSource = $this->console->getContainer()->getParameter('vitre_php_console.detect_trace_and_source');
        }
    }

    protected function initHandler()
    {
        $this->handler = Handler::getInstance();

        // disable exceptions handling
        $this->handler->setHandleExceptions($this->console->getContainer()->getParameter('vitre_php_console.handle.exceptions'));

        // disable errors handling
        $this->handler->setHandleErrors($this->console->getContainer()->getParameter('vitre_php_console.handle.errors'));

        // disable passing errors & exceptions to prviously defined handlers
        $this->handler->setCallOldHandlers($this->console->getContainer()->getParameter('vitre_php_console.handle.forward'));

        $this->handler->start();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getConsole()
    {
        return $this->console;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function log()
    {
        $args = func_get_args();
        call_user_func_array([$this->connection->getDebugDispatcher(), 'dispatchDebug'], $args);

        return $this;
    }

    public function info()
    {
        return call_user_func_array([__CLASS__, 'log'], func_get_args());
    }

    public function group()
    {
        return call_user_func_array([__CLASS__, 'log'], func_get_args());
    }

    public function groupEnd()
    {

    }

    public function table()
    {
        return call_user_func_array([__CLASS__, 'log'], func_get_args());
    }

}