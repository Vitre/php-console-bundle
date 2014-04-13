<?php

namespace Vitre\PhpConsoleBundle;

abstract class AbstractDriver
{

    protected $connection = false;

    protected $console;

    //---

    public function __construct($console)
    {
        $this->console = $console;

        return $this;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getConsole()
    {
        return $this->console;
    }

}