<?php


namespace rollun\utils\Metrics\Callback;


use rollun\dic\InsideConstruct;
use rollun\utils\Metrics\ProcessTrackerInterface;

class ClearOldProcessesDataCallback
{
    /** @var ProcessTrackerInterface */
    protected $processTracker;

    public function __construct(ProcessTrackerInterface $processTracker = null)
    {
        InsideConstruct::init([
            'processTracker' => ProcessTrackerInterface::class,
        ]);
    }

    public function __invoke()
    {
        $this->processTracker->clearOldProcessesData();
    }
}