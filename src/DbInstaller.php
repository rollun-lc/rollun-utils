<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14.03.17
 * Time: 16:49
 */

namespace rollun\utils;

use rollun\installer\Install\InstallerAbstract;
use Zend\Db\Adapter\AdapterAbstractServiceFactory;
use Zend\Db\Adapter\AdapterInterface;

class DbInstaller extends InstallerAbstract
{

    /**
     * install
     * @return array
     */
    public function install()
    {
        $config = [
        'dependencies' => [
                'abstract_factories' => [
                    AdapterAbstractServiceFactory::class,
                ],
                'aliases' => [
                    'db' => AdapterInterface::class,
                ]
            ]
        ];
        if ($this->consoleIO->askConfirmation("Do you want to start the process of generating a config file?", false)) {
            $drivers = ['IbmDb2', 'Mysqli', 'Oci8', 'Pgsql', 'Sqlsrv', 'Pdo_Mysql', 'Pdo_Sqlite', 'Pdo_Pgsql'];
            $index = $this->consoleIO->select("", $drivers, 5);

            do {
                $dbName = $this->consoleIO->ask("Set database name:");
                if (is_null($dbName)) {
                    $this->consoleIO->write("You not set, database name");
                }
            } while ($dbName == null);
            do {
                $dbUser = $this->consoleIO->ask("Set database user name:");
                if (is_null($dbUser)) {
                    $this->consoleIO->write("You not set, database user name");
                }
            } while ($dbUser == null);
            $dbPass = $this->consoleIO->askAndHideAnswer("Set database password:");

            $config['db'] = [
                'adapters' => [
                    AdapterInterface::class => [
                        'driver' => $drivers[$index],
                        'database' => $dbName,
                        'username' => $dbUser,
                        'password' => $dbPass
                    ]
                ]
            ];
        } else {
            //do {
                $this->consoleIO->write("You must create config for db adapter, with adapter name 'db'.");
                $answer = $this->consoleIO->askConfirmation("Is the config file created?");
                /*if (!$answer || !$this->container->has('db')) {
                    $this->consoleIO->write("You not create correct config for adapter.");
                }*/
            //} while (!$answer || !$this->container->has('db'));
        }
        return $config;
    }

    public function isInstall()
    {

        $config = $this->container->get('config');
        //return false;
        $result = isset($config['dependencies']['abstract_factories']) &&
            $this->container->has('db') &&
            in_array(AdapterAbstractServiceFactory::class, $config['dependencies']['abstract_factories']);
        return $result;
    }
    
    /**
     * Clean all installation
     * @return void
     */
    public function uninstall()
    {
        // TODO: Implement uninstall() method.
    }

    /**
     * Return string with description of installable functional.
     * @param string $lang ; set select language for description getted.
     * @return string
     */
    public function getDescription($lang = "en")
    {
        switch ($lang) {
            case "ru":
                $description = "Позволяет представить таблицу в DB в качестве хранилища.";
                break;
            default:
                $description = "Does not exist.";
        }
        return $description;
    }
}
