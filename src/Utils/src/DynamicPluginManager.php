<?php


namespace rollun\utils;


use Laminas\ServiceManager\AbstractPluginManager;

/**
 * Class PluginManager
 * @package rollun\utils
 *
 *
 * $configDataSource is php config or dataSource.
 * Contain config for build service.
 * [
 *      '' => [
 *
 *      ]
 * ]
 */
class DynamicPluginManager extends AbstractPluginManager
{
    public function __construct(private $configDataSource, string $instanceOf, $configInstanceOrParentLocator = null, array $config = [])
    {
        parent::__construct($configInstanceOrParentLocator, $config);
        $this->instanceOf = $instanceOf;
    }

    public function get($name, array $options = null)
    {
        if (method_exists($this->configDataSource, 'getAll')) {
            $config = $this->configDataSource->getAll();
        } else {
            $config = $this->configDataSource;
        }
        if (isset($config[$name])) {
            $options = $config[$name];
        }

        return parent::get($name, $options);
    }
}