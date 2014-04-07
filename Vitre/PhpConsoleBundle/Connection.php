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

        $this->connect();

        PhpConsole\Helper::register();
    }

    protected function configure()
    {
        $this->connection->setSourcesBasePath($this->container->get('kernel')->getRootDir());
        //$this->connection->setPassword('aaa', true);
        //$this->connection->setAllowedIpMasks(array('192.168.*.*'));
        //$this->connection->getDebugDispatcher()->detectTraceAndSource = true;
    }

    protected function initHandler()
    {
        $this->handler = Handler::getInstance();
        $this->handler->setHandleExceptions(false); // disable exceptions handling
        //$this->handler->setHandleErrors(true); // disable errors handling
        $this->handler->setCallOldHandlers(true); // disable passing errors & exceptions to prviously defined handlers
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

        call_user_func_array([$this->connection->getDebugDispatcher(), 'dispatchDebug'], func_get_args());

        return $this;
    }


}