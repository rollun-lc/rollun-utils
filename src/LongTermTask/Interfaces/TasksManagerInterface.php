<?php

namespace rollun\callback\LongTermTask\Interfaces;

use rollun\callback\LongTermTask\Interfaces\Results\Task\TaskTypeInfoResultInterface;
use rollun\callback\LongTermTask\Interfaces\Results\Task\TaskTypeListResultInterface;

interface TasksManagerInterface
{
    /**
     * Return list of tasks type
     * @return TaskTypeListResultInterface
     */
    public function getTaskTypeList(): TaskTypeListResultInterface;

    /**
     * Return TaskType info
     *
     * @param string $taskType
     * @return TaskTypeInfoResultInterface
     */
    public function getTaskTypeInfoByTaskType(string $taskType): TaskTypeInfoResultInterface;
}