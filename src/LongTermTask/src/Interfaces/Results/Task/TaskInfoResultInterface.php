<?php
declare(strict_types=1);

namespace rollun\LongTermTask\Interfaces\Results\Task;

use rollun\LongTermTask\Interfaces\Results\ResultInterface;

/**
 * Interface TaskInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TaskInfoResultInterface extends ResultInterface
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
     *
     * Get datetimewhen task was start
     *
     * @return \DateTime|null UTC DateTime in result
     */
    public function getStartTime(): ?\DateTime;
}
