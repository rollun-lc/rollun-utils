<?php
declare(strict_types=1);

namespace rollun\Callables\TaskExample\Result\Data;

use rollun\Callables\Task\Async\Result\Data\TaskTypeInfoInterface;
use rollun\Callables\Task\Async\Result\StatusInterface;

/**
 * Class FileSummaryType
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class FileSummaryType implements TaskTypeInfoInterface
{
    /**
     * @var array
     */
    protected $stages;

    /**
     * FileSummaryType constructor.
     *
     * @param array $stages
     */
    public function __construct(array $stages)
    {
        $this->stages = $stages;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return __CLASS__;
    }

    /**
     * @inheritDoc
     */
    public function getTimeout(): int
    {
        return 3;
    }

    /**
     * @inheritDoc
     */
    public function getAllStatuses(): array
    {
        return [StatusInterface::STATE_PENDING, StatusInterface::STATE_FULFILLED, StatusInterface::STATE_REJECTED];
    }

    /**
     * @inheritDoc
     */
    public function getAllStages(): array
    {
        return $this->stages;
    }
}
