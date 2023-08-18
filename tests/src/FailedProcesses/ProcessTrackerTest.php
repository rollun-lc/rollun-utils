<?php

namespace rollun\test\utils\FailedProcesses;

use PHPUnit\Framework\TestCase;
use rollun\logger\LifeCycleToken;
use rollun\utils\FailedProcesses\Service\ProcessTracker;

class ProcessTrackerTest extends TestCase
{
    protected string $dirPath;
    private const PROCESS_TRACKING_DIR = 'data/process-tracking/';

    private const ENV_TRACK_PROCESSES = 'TRACK_PROCESSES';

    protected function setUp(): void
    {
        $this->dirPath = static::getProcessTrackingDir() . static::getTodayDir();
    }

    public function testCreateFileSuccess(): void
    {
        global $container;
        $obj = new ProcessTracker();
        \rollun\dic\InsideConstruct::setContainer($container);
        $lifeCycleToken = LifeCycleToken::generateToken();
        $obj::storeProcessData($lifeCycleToken);

        $this->assertFileExists($this->dirPath . $lifeCycleToken);
    }
    public function testCreateFileFail(): void
    {
        global $container;
        $obj = new ProcessTracker();
        \rollun\dic\InsideConstruct::setContainer($container);
        $lifeCycleToken = LifeCycleToken::generateToken();
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
}