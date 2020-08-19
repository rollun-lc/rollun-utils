<?php
declare(strict_types=1);

namespace rollun\Callables\LongTermTask\Interfaces;

use rollun\Callables\LongTermTask\Interfaces\Results\Task\TaskInfoResultInterface;
use rollun\Callables\LongTermTask\Interfaces\Results\Task\TaskTypeInfoResultInterface;
use rollun\Callables\Results\Interfaces\ResultInterface;

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
     * @return TaskInfoResultInterface|ResultInterface
     */
    public function createTask(object $task): ResultInterface;

    /**
     * Delete task
     *
     * @param string $id
     *
     * @return ResultInterface
     */
    public function deleteById(string $id): ResultInterface;
}