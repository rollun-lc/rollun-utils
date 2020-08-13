<?php
declare(strict_types=1);

namespace rollun\LongTermTask\Interfaces\Results\Task;

/**
 * Interface TaskTypeInfoInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TaskTypeInfoInterface
{
    /**
     * Get task type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Get task timeout
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
}
