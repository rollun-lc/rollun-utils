<?php

namespace rollun\test\Unit\Utils\TableGateway\Factory;

use PHPUnit\Framework\TestCase;
use rollun\tableGateway\TableManagerMysql;
use rollun\test\tableGateway\Factory\ContainerInterface;
use rollun\test\tableGateway\Factory\Returner;
use Zend\Db\Adapter\Adapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-29 at 18:23:51.
 */
class TableManagerMysqlFactoryTest extends TestCase
{

    /**
     * @var Returner
     */
    protected $object;

    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->container = include './config/container.php';
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    public function testTableGatewayAbstractFactory__canCreateIfTableAbsent()
    {
        $this->markTestIncomplete('Zend\ServiceManager\Exception\ServiceNotFoundException : Unable to resolve service "TableManagerMysql" to a factory; are you certain you provided it during configuration?');
        $this->object = $this->container->get('TableManagerMysql');
        $this->assertSame(
            get_class($this->object), TableManagerMysql::class
        );
    }

}
