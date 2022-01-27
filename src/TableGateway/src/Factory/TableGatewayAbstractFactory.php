<?php

/**
 * Zaboy lib (http://zaboy.org/lib/)
 *
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace rollun\tableGateway\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Db\Metadata\Metadata;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;

/**
 * Create and return an instance of the TableGateway
 *
 * Return TableGateway if table with name $requestedName
 * present in database
 *
 * Requre service with name 'db' - db adapter
 *
 * @uses zend-db
 * @see https://github.com/zendframework/zend-db
 * @category   rest
 * @package    zaboy
 */
class TableGatewayAbstractFactory implements AbstractFactoryInterface
{

    const KEY = self::KEY_TABLE_GATEWAY;

    const KEY_SQL = 'sql';

    /**
     * @deprecated
     */
    const KEY_TABLE_GATEWAY = 'tableGateway';
    /*
     * @var array cache of tables names in db
     */

    protected $tableNames = null;

    /*
     * @var Laminas\Db\Adapter\AdapterInterface
     */
    protected $db;

    const KEY_ADAPTER = 'adapter';

    /**
     * Can the factory create an instance for the service?
     *
     * For Service manager V3
     * Edit 'use' section if need:
     * Change:
     * 'use Laminas\ServiceManager\AbstractFactoryInterface;' for V2 to
     * 'use Laminas\ServiceManager\Factory\AbstractFactoryInterface;' for V3
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        //is there table with same name (for static tables set)?
        //$tableNames = $this->getCachedTables($container);
        //is there table with same name (for non static tables set)?
        $config = $container->get('config');
        if (!isset($config[TableGatewayAbstractFactory::KEY][$requestedName])) {
            return false;
        }
        if ($this->setDbAdapter($container, $requestedName)) {
            $dbMetadata = new Metadata($this->db);
            $this->tableNames = array_merge($dbMetadata->getTableNames(),  $dbMetadata->getViewNames());
        }
        return is_array($this->tableNames) && in_array($requestedName, $this->tableNames, true);
    }

    /**
     *
     * @param ContainerInterface $container
     * @param $requestedName
     * @return bool
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function setDbAdapter(ContainerInterface $container, $requestedName)
    {

        $config = $container->get('config')[TableGatewayAbstractFactory::KEY];
        if (isset($config[$requestedName]) && isset($config[$requestedName][static::KEY_ADAPTER])) {
            $this->db = $container->has($config[$requestedName][static::KEY_ADAPTER]) ?
                $container->get($config[$requestedName][static::KEY_ADAPTER]) : false;
        } else {
            $this->db = $container->has('db') ? $container->get('db') : false;
        }
        return (bool)$this->db;
    }

    /**
     * Create and return an instance of the TableGateway.
     *
     * 'use Laminas\ServiceManager\AbstractFactoryInterface;' for V2 to
     * 'use Laminas\ServiceManager\Factory\AbstractFactoryInterface;' for V3
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  array $options
     * @return TableGateway
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        if (isset($config[self::KEY][$requestedName][self::KEY_SQL]) and is_a($config[self::KEY][$requestedName][self::KEY_SQL], 'Laminas\Db\Sql\Sql', true)) {
            $sql = new $config[self::KEY][$requestedName][self::KEY_SQL]($this->db, $requestedName);
            return new TableGateway($requestedName, $this->db, null, null, $sql);
        }

        return new TableGateway($requestedName, $this->db);

    }

    /**
     * For static tables set
     *
     * @param ContainerInterface $container
     * @return array|false
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getCachedTables(ContainerInterface $container)
    {
        if (!isset($this->tableNames)) {
            if ($this->setDbAdapter($container)) {
                $dbMetadata = new Metadata($this->db);
                $this->tableNames = $dbMetadata->getTableNames();
            } else {
                $this->tableNames = false;
            }
        }
        return $this->tableNames;
    }

}
