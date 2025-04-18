<?php

namespace rollun\Downloader\Factory;

use Psr\Container\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use rollun\Downloader\FtpDownloader;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;

class FtpDownloaderAbstractFactory implements AbstractFactoryInterface
{
    const KEY = FtpDownloaderAbstractFactory::class;

    const KEY_FTP_CLIENT = "ftp_client";

    const KEY_TARGET_FILE_PATH = "target_file_path";

    const KEY_DESTINATION_FILE_PATH = "destination_file_path";

    /**
     * Can the factory create an instance for the service?
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        try {
            $config = $container->get("config");
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface) {
            return false;
        }
        return (isset($config[static::KEY][$requestedName]));
    }

    /**
     * Create an object
     * [
     *      "downloader" => [
     *          FtpDownloaderAbstractFactory::KEY_FTP_CLIENT => "ftpClient"
     *          FtpDownloaderAbstractFactory::KEY_TARGET_FILE_PATH => "file.csv"
     *          FtpDownloaderAbstractFactory::KEY_DESTINATION_FILE_PATH => "data/tmp/file.csv"
     *      ]
     * ]
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return FtpDownloader
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get("config");
        $factoryConfig = $config[static::KEY][$requestedName];
        $ftpClient = $container->get($factoryConfig[static::KEY_FTP_CLIENT]);
        $targetFilePath = $factoryConfig[static::KEY_TARGET_FILE_PATH];
        $destinationFilePath = $factoryConfig[static::KEY_DESTINATION_FILE_PATH];
        return new FtpDownloader($ftpClient, $targetFilePath, $destinationFilePath);
    }
}