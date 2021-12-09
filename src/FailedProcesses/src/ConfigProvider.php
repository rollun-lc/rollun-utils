<?php

namespace rollun\utils\FailedProcesses;

use rollun\utils\FailedProcesses\Callback\ClearOldProcessesDataCallback;
use rollun\utils\FailedProcesses\Controller\ProcessData1Controller;
use rollun\utils\FailedProcesses\Service\ProcessTracker;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'invokables' => [
                'ProcessData1Controller' => ProcessData1Controller::class,
                ClearOldProcessesDataCallback::class => ClearOldProcessesDataCallback::class,
                ProcessTracker::class => ProcessTracker::class,
            ],
        ];
    }
}
