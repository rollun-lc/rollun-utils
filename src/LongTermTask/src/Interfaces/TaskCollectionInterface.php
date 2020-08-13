<?php
declare(strict_types=1);

namespace rollun\LongTermTask\Interfaces;

use rollun\LongTermTask\Interfaces\Results\ResultInterface;
use rollun\LongTermTask\Interfaces\Results\Task\CreateTaskResultInterface;
use rollun\LongTermTask\Interfaces\Results\Task\DeletedTaskResultInterface;
use rollun\LongTermTask\Interfaces\Results\Task\TaskInfoResultInterface;
use rollun\LongTermTask\Interfaces\Results\Task\TaskTypeInfoResultInterface;

/**
 * Interface TaskCollectionInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
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
     *
     * @return TaskInfoResultInterface
     */
    public function getTaskInfoById(string $taskId): TaskInfoResultInterface;

    /**
     * Create new task, return id
     *
     * @param object $task
     *
     * @return TaskInfoResultInterface
     */
    public function createTask(object $task): TaskInfoResultInterface;

    /**
     * Delete task
     *
     * @param string $id
     *
     * @return ResultInterface
     */
    public function deleteById(string $id): ResultInterface;
}