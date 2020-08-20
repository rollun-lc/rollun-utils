<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Interfaces\Async;

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
}