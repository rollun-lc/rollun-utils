<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Interfaces;

use rollun\Callables\Results\Interfaces\ResultInterface;

/**
 * Interface TaskCollectionInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TaskCollectionInterface
{
    /**
     * @param object $task
     *
     * @return ResultInterface
     */
    public function createTask(object $task): ResultInterface;
}