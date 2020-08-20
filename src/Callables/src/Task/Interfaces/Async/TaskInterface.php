<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Interfaces\Async;

use rollun\Callables\Task\Interfaces\TaskInterface as SyncTaskInterface;
use rollun\Callables\Task\Interfaces\Async\Results\TaskInfoResultInterface;
use rollun\Callables\Results\Interfaces\ResultInterface;

/**
 * Interface TaskInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TaskInterface extends SyncTaskInterface
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
     * Get concreted task result by id
     *
     * @param string $taskId
     *
     * @return ResultInterface
     */
    public function getTaskResultById(string $taskId): ResultInterface;

    /**
     * Create new task
     *
     * @param object $task
     *
     * @return TaskInfoResultInterface
     */
    public function runTask(object $task): ResultInterface;

    /**
     * Delete task
     *
     * @param string $id
     *
     * @return ResultInterface
     */
    public function deleteById(string $id): ResultInterface;
}