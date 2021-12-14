<?php


namespace rollun\utils\FailedProcesses\Callback;


use rollun\dic\InsideConstruct;
use rollun\utils\FailedProcesses\Service\ProcessTracker;

class ClearOldProcessesDataCallback
{
    /** @var ProcessTracker */
    private $processTracker;

    public function __construct(ProcessTracker $processTracker = null)
    {
        InsideConstruct::init([
            'processTracker' => ProcessTracker::class,
        ]);
    }

    public function __wakeup()
    {
        InsideConstruct::initWakeup([
            'processTracker' => ProcessTracker::class,
        ]);
    }

    public function __sleep() {
        return [];
    }

    public function __invoke()
    {
        $this->processTracker->clearOldProcessesData();
    }
}