<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Interfaces\Async;

use rollun\Callables\Task\Interfaces\TaskCollectionInterface as SyncTaskCollectionInterface;
use rollun\Callables\Task\Interfaces\Async\Results\TaskInfoResultInterface;
use rollun\Callables\Results\Interfaces\ResultInterface;

/**
 * Interface TaskCollectionInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TaskCollectionInterface extends SyncTaskCollectionInterface
{
    /**
     * Return concreted task info by id
     *
     * @param string $taskId
     *
     * @return TaskInfoResultInterface
     */
    public function getTaskInfoById(string $taskId): TaskInfoResultInterface;

    /**
     * Create new task
     *
     * @param object $task
     *
     * @return TaskInfoResultInterface
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