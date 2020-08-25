<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Async\Result;

use rollun\Callables\Task\Result\Status as SyncStatus;

/**
 * Class Status
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class Status extends SyncStatus implements StatusInterface
{
    /**
     * Status constructor.
     *
     * @param string|null $state
     */
    public function __construct(string $state = null)
    {
        $this->state = empty($state) ? StatusInterface::STATE_PENDING : $state;
    }

    /**
     * @inheritDoc
     */
    public function isPending(): bool
    {
        return $this->getState() === StatusInterface::STATE_PENDING;
    }

    /**
     * @inheritDoc
     */
    public function toReject(): void
    {
        $this->state = StatusInterface::STATE_REJECTED;
    }

    /**
     * @inheritDoc
     */
    public function toFulfilled(): void
    {
        $this->state = StatusInterface::STATE_FULFILLED;
    }
}
