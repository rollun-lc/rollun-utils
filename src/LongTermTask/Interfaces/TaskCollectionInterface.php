<?php

namespace rollun\callback\LongTermTask\Interfaces;

use rollun\callback\LongTermTask\Interfaces\Results\Task\CreateTaskResultInterface;
use rollun\callback\LongTermTask\Interfaces\Results\Task\DeletedTaskResultInterface;
use rollun\callback\LongTermTask\Interfaces\Results\Task\TaskInfoResultInterface;
use rollun\callback\LongTermTask\Interfaces\Results\Task\TaskTypeInfoResultInterface;

interface TaskCollectionInterface
{
    /**
     * Return tasks typeInfo in collection
     *
     * @return TaskTypeInfoResultInterface
     */
    public function getTaskTypeInfo(): TaskTypeInfoResultInterface;

    /**
     * Return concreted task info by id
     *
     * @param string $taskId
     * @return TaskInfoResultInterface
     */
    public function getTaskInfoById(string $taskId): TaskInfoResultInterface;

    /**
     * Create new task, return id
     * @param object $task
     * @return CreateTaskResultInterface
     */
    public function createTask(object $task): CreateTaskResultInterface;

    /**
     * Delete task
     * @param string $id
     */
    public function deleteById(string $id): DeletedTaskResultInterface;
}