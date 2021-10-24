<?php

namespace rollun\utils\Metrics;

interface ProcessTrackerInterface
{
    public static function storeProcessData(string $lifeCycleToken, string $parentLifeCycleToken = null);

    public static function clearProcessData();

    public static function clearOldProcessesData();
}