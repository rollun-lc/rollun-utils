<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.01.17
 * Time: 14:13
 */

namespace rollun\installer\Example;

use rollun\installer\Install\InstallerAbstract;
use Zend\ServiceManager\ServiceManager;

/**
 * Set alias "defaultDbAdapter" => Existed\Service\Of\DbAdapter::class
 */
class DoNothingInstaller extends InstallerAbstract
{

    const DEF_DB_NAME = "defaultDbAdapter";

    public function install()
    {
        if ($this->container->has(self::DEF_DB_NAME)) {
            return []; // -  there is no need in alias for "defaultDbAdapter"
        }

        $defDbAdapterName = $this->getDbAdapterNameForAlias();
        if (!isset($defDbAdapterName)) {
            $tableName = GmailDbDataStore::DEFAULT_TABLE_NAME;
            $this->consoleIO->write("There is not DbAdapter for alias\n");
            $this->consoleIO->write("Add it to config and run this installer again.\n");
            return [];
        }
        $config = [
            'dependencies' => [
                'aliases' => [
                    self::DEF_DB_NAME => $defDbAdapterName,
                ],
            ],
        ];
        //add it in ServiceManagerRight now!
        $this->container->setAlias(self::DEF_DB_NAME, $defDbAdapterName);
        //add it in config for next run
        return $config;
    }

    protected function getDefaultDbAdapterName()
    {
        $defaultAdapterNames = [
            ZendDbAdapterInterface::class,
            ZendDbAdapter::class,
            'db'
        ];
        foreach ($defaultAdapterNames as $serviceName) {
            if ($this->container->has($serviceName)) {
                return $serviceName;
            }
        }
        return null;
    }

    protected function getAllDbAdaptersNames()
    {
        if (!$this->container->has('config')) {
            return [];
        }
        $config = $this->container->get('config');
        if (!isset($config['db']['adapters'])) {
            return [];
        }
        return array_keys($config['db']['adapters']);
    }

    protected function getDbAdapterNameForAlias()
    {
        $defaultDbAdapterName = $this->getDefaultDbAdapterName();
        if (isset($defaultDbAdapterName)) {
            $question = "Do you want to use default DbAdapter for alias to " . self::DEF_DB_NAME . "? y/n/q";
            $answer = $this->askYesNoQuit($question, 'y', true);
            if ($answer == 'y') {
                return $defaultDbAdapterName;
            }
        }
        $adaptersNames = $this->getAllDbAdaptersNames();
        if ($adaptersNames !== []) {
            array_unshift($adaptersNames, "None of the following");
            $answer = $this->consoleIO->select($question, $adaptersNames, false);
            if ($answer == "0") {
                return null;
            } else {
                return $adaptersNames[(int) $answer];
            }
        } else {
            $this->consoleIO->write("There are not DbAdapters found in ServiceManger\n");
            return null;
        }
    }

    public function getDependencyInstallers()
    {
        return [
                //DbInstaller::class,
        ];
    }

    public function isInstall()
    {
        return $this->container->has(self::DEF_DB_NAME);
    }

    public function uninstall()
    {
        if (!$this->isInstall()) {
            $this->consoleIO->write("There is not installed");
        } else {
            $this->consoleIO->write("Delete alias for " . self::DEF_DB_NAME . " from config");
        }
    }

    /**
     * Return string with description of installable functional.
     * @param string $lang ; set select language for description getted.
     * @return string
     */
    public function getDescription($lang = "en")
    {
        switch ($lang) {
            case "en":
                $description = "It make alias for " . self::DEF_DB_NAME;
                break;
            case "ru":
                $description = "Создает алиас для " . self::DEF_DB_NAME;
                break;
            default:
                $description = "Does not exist.";
        }
        return $description;
    }

}
