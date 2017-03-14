<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14.03.17
 * Time: 16:49
 */

namespace rollun\utils;

use rollun\installer\Install\InstallerAbstract;

class DbInstaller extends InstallerAbstract
{

    /**
     * install
     * @return array
     */
    public function install()
    {
        $config = [];
        if ($this->consoleIO->askConfirmation("you want to add a configuration to connect to the database itself(else we generate it ourselves) ?", false)) {
            do {
                $this->consoleIO->write("You mast create config for db adapter, with adapter name 'db'.");
                $answer = $this->consoleIO->askConfirmation("Is the config file created?");
                if (!$answer || !$this->container->has('db')) {
                    $this->consoleIO->write("You not create correct config for adapter.");
                }
            } while (!$answer || !$this->container->has('db'));
        } else {
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
                    'db' => [
                        'driver' => $drivers[$index],
                        'database' => $dbName,
                        'username' => $dbUser,
                        'password' => $dbPass
                    ]
                ]
            ];
        }
        return $config;
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
