<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Interfaces;

use rollun\Callables\Results\Interfaces\ResultInterface;

/**
 * Interface TaskInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TaskInterface
{
    /**
     * Run task
     *
     * @param object $task
     *
     * @return ResultInterface
     */
    public function runTask(object $task): ResultInterface;
}