<?php


namespace Vitre\PhpConsoleBundle;

interface ConnectionInterface
{

    public function __construct($console);

    public function connect();

    public function log();

    public function getConsole();

}