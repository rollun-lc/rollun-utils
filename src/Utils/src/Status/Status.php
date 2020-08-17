<?php
declare(strict_types=1);

namespace rollun\utils\Status;

/**
 * Class Status
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class Status implements StatusInterface
{
    /**
     * @var string
     */
    protected $state = StatusInterface::STATE_PENDING;

    /**
     * @inheritDoc
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @inheritDoc
     */
    public function isPending(): bool
    {
        return $this->getState() == StatusInterface::STATE_PENDING;
    }

    /**
     * @inheritDoc
     */
    public function isFulfilled(): bool
    {
        return $this->getState() == StatusInterface::STATE_FULFILLED;
    }

    /**
     * @inheritDoc
     */
    public function toFulfilled(): void
    {
        $this->state = StatusInterface::STATE_FULFILLED;
    }

    /**
     * @inheritDoc
     */
    public function isRejected(): bool
    {
        return $this->getState() == StatusInterface::STATE_REJECTED;
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
    public function __toString(): string
    {
        return $this->getState();
    }
}
