<?php

namespace Vitre\PhpConsoleBundle;

interface DriverInterface
{

    public function __construct($console);

    public function connect();

    public function log();

    public function warn();

    public function getConsole();

    public function group();

    public function groupEnd();

    public function table();

    public function info();

}
