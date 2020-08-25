<?php
declare(strict_types=1);

namespace rollun\Callables\TaskExample\Result\Data;

use rollun\Callables\Task\Async\Result\Data\TaskInfoInterface;
use rollun\Callables\Task\Async\Result\Data\TaskTypeInfoInterface;
use rollun\Callables\Task\Async\ResultInterface;

/**
 * Class FileSummaryInfo
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class FileSummaryInfo implements TaskInfoInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $stage;

    /**
     * @var TaskTypeInfoInterface
     */
    protected $taskTypeInfo;

    /**
     * @var ResultInterface
     */
    protected $result;

    /**
     * FileSummaryInfo constructor.
     *
     * @param string                $id
     * @param TaskTypeInfoInterface $taskTypeInfo
     * @param ResultInterface       $result
     * @param string                $stage
     */
    public function __construct(string $id, TaskTypeInfoInterface $taskTypeInfo, ResultInterface $result, string $stage = '')
    {
        $this->id = $id;
        $this->taskTypeInfo = $taskTypeInfo;
        $this->result = $result;
        $this->stage = (empty($stage) && isset($taskTypeInfo->getAllStages()[0])) ? $taskTypeInfo->getAllStages()[0] : $stage;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getStage(): string
    {
        return $this->stage;
    }

    /**
     * @inheritDoc
     */
    public function setStage(string $stage): void
    {
        if (!in_array($stage, $this->getTaskTypeInfo()->getAllStages())) {
            throw new \InvalidArgumentException('No such stage');
        }

        $this->stage = $stage;
    }

    /**
     * @inheritDoc
     */
    public function getStartTime(): ?\DateTime
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getTaskTypeInfo(): TaskTypeInfoInterface
    {
        return $this->taskTypeInfo;
    }

    /**
     * @inheritDoc
     */
    public function getResult(): ResultInterface
    {
        return $this->result;
    }
}
