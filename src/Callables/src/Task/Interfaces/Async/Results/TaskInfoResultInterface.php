<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Interfaces\Async\Results;

use rollun\Callables\Results\Interfaces\ResultInterface;
use rollun\Callables\Status\Interfaces\StatusInterface;
use rollun\Callables\Status\Interfaces\Async\StatusInterface as AsyncStatusInterface;
use rollun\Callables\Task\Interfaces\Async\TaskInfoInterface;

/**
 * Interface TaskInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TaskInfoResultInterface extends ResultInterface
{
    /**
     * @return TaskInfoInterface
     */
    public function getData();

    /**
     * Get current status
     *
     * @return AsyncStatusInterface
     */
    public function getStatus(): StatusInterface;
}