<?php

namespace Rollun\Test\Unit\Utils\FailedProcesses;

use PHPUnit\Framework\TestCase;
use rollun\dic\InsideConstruct;
use rollun\utils\FailedProcesses\Service\ProcessTracker;

class ProcessTrackerTest extends TestCase
{
    protected string $dirPath;
    private const PROCESS_TRACKING_DIR = 'data/process-tracking/';

    protected function setUp(): void
    {
        $this->dirPath = static::getProcessTrackingDir() . static::getTodayDir();
    }

    public function testCreateFileSuccess(): void
    {
        global $container;
        $obj = new ProcessTracker();
        InsideConstruct::setContainer($container);
        $lifeCycleToken = self::generateLifeCycleToken();
        $obj::storeProcessData($lifeCycleToken);

        $this->assertFileExists($this->dirPath . $lifeCycleToken);
    }
    public function testCreateFileFail(): void
    {
        global $container;
        $obj = new ProcessTracker();
        InsideConstruct::setContainer($container);
        $lifeCycleToken = self::generateLifeCycleToken();
        $obj::storeProcessData($lifeCycleToken);

        $this->assertFileDoesNotExist($this->dirPath . 'randomFileName');
    }

    private static function getProcessTrackingDir(): string
    {
        return self::PROCESS_TRACKING_DIR;
    }

    private static function getTodayDir(): string
    {
        return (new \DateTime())->format('Y-m-d') . '/';
    }

    public static function generateLifeCycleToken(int $nums = 30)
    {
        $idCharSet = "QWERTYUIOPASDFGHJKLZXCVBNM0123456789";

        $id = [];
        $idCharSetArray = str_split($idCharSet);
        $charArrayCount = count($idCharSetArray) - 1;

        for ($i = 0; $i < $nums; $i++) {
            $id[$i] = $idCharSetArray[random_int(0, $charArrayCount)];
        }

        $id = implode("", $id);

        return $id;
    }
}