<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Interfaces\Async;

use rollun\Callables\Results\Interfaces\ResultInterface;

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
     * @return string
     */
    public function getType(): string;

    /**
     * Get task current status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Get task current stage
     *
     * @return string
     */
    public function getStage(): string;

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
     * @return ResultInterface|null
     */
    public function getResult(): ?ResultInterface;
}
