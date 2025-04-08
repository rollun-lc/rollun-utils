<?php

namespace rollun\Downloader;

use FtpClient\FtpClient;

class FtpDownloader
{
    /** @var FtpClient */
    protected $ftpClient;

    /**
     * FtpDownloader constructor.
     * @param FtpClient $ftpClient client is already connected & loggined
     * @param $destinationFilePath
     * @param $targetFilePath
     * @param string $targetFilePath
     * @param string $destinationFilePath
     */
    public function __construct(FtpClient $ftpClient, /**
     * Target remote file which be downloaded
     */
    protected $targetFilePath, /**
     * File path were data will be stored
     */
    protected $destinationFilePath)
    {
        $this->ftpClient = $ftpClient;
    }

    /**
     * Download
     */
    public function download() {
        try {
            $this->ftpClient->chdir(dirname($this->targetFilePath));
            if($this->ftpClient->get($this->destinationFilePath, $this->targetFilePath, FTP_BINARY)) {
                throw new \RuntimeException("File not be download");
            }
        } catch (\Throwable $throwable) {
            throw new FtpException("Exception by download file", $throwable->getCode(), $throwable);
        }
    }
}