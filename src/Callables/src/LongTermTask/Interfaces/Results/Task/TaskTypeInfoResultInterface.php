<?php
declare(strict_types=1);

namespace rollun\Callables\LongTermTask\Interfaces\Results\Task;

use rollun\Callables\Results\Interfaces\ResultInterface;

/**
 * Interface TaskTypeInfoResultInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TaskTypeInfoResultInterface extends ResultInterface
{
    /**
     * TaskType specific info
     *
     * @return TaskTypeInfoInterface
     */
    public function getData();
}
