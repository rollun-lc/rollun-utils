<?php
declare(strict_types=1);

namespace rollun\LongTermTask\Interfaces\Results\Task;

use rollun\LongTermTask\Interfaces\Results\ResultInterface;

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
