<?php
declare(strict_types=1);

namespace rollun\LongTermTask\Interfaces\Results\Task;

use rollun\LongTermTask\Interfaces\Results\ResultInterface;

/**
 * Interface TaskTypeInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TaskTypeInfoResultInterface extends ResultInterface
{

    /**
     * Return Task type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Get mat task timeout
     *
     * @return int
     */
    public function getTimeout(): int;

    /**
     * Get all possible task type statuses
     *
     * @return string[]
     */
    public function getAllStatuses(): array;

    /**
     * Get all possible task type stages
     *
     * @return string[]
     */
    public function getAllStages(): array;

    /**
     * TaskType specific info
     *
     * @return object|null
     */
    public function getData();
}
