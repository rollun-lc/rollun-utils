<?php

namespace rollun\utils\FailedProcesses\Controller;

use rollun\utils\FailedProcesses\Service\ProcessTracker;

class ProcessData1Controller
{
    public function get($queryData = [])
    {
        return [
            'data' => ProcessTracker::getAllData(),
        ];
    }
}