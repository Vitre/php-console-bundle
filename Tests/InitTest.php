<?php

use Symfony\Bundle\FrameworkBundle\Console\Application;

class BuilderAliasProviderTest extends \PHPUnit_Framework_TestCase
{

    private $kernel;

    protected function setUp()
    {
        $kernel = new AppKernel('dev', true);
        $kernel->boot();
        $this->kernel = $kernel;
    }

    public function testInit()
    {
        $var = array('ArrayTest' => 'ArrayTest');
        $this->kernel->getContainer()->get('vitre_php_console')->log($var);
    }

}
