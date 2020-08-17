<?php
declare(strict_types=1);

namespace rollun\Callables\LongTermTask\Interfaces\Results\Task;

use rollun\Callables\Results\ResultInterface;

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
}
