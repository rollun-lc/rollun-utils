<?php

namespace rollun\utils\FailedProcesses\Service;

interface ProcessTrackerInterface
{
    public static function storeProcessData(string $lifeCycleToken, string $parentLifeCycleToken = null);
}