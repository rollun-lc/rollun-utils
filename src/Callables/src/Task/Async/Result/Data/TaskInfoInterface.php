<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Async\Result\Data;

use rollun\Callables\Task\ResultInterface;
use rollun\Callables\Task\Async\Result\StatusInterface;

/**
 * Interface TaskInfoInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TaskInfoInterface
{
    /**
     * Get task id
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Get task current stage
     *
     * @return string
     */
    public function getStage(): string;

    /**
     * Set task current stage
     *
     * @param string $stage
     */
    public function setStage(string $stage): void;

    /**
     * Get status
     *
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface;

    /**
     * Get datetime when task was start
     *
     * @return \DateTime|null UTC DateTime in result
     */
    public function getStartTime(): ?\DateTime;

    /**
     * Get task type info
     *
     * @return TaskTypeInfoInterface
     */
    public function getTaskTypeInfo(): TaskTypeInfoInterface;

    /**
     * Get task result
     *
     * @return ResultInterface
     */
    public function getResult(): ResultInterface;
}
