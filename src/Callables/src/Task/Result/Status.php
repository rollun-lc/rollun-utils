<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Result;

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
    protected $state;

    /**
     * Status constructor.
     */
    public function __construct()
    {
        $this->state = StatusInterface::STATE_FULFILLED;
    }

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
    public function isRejected(): bool
    {
        return $this->getState() === StatusInterface::STATE_REJECTED;
    }

    /**
     * @inheritDoc
     */
    public function isFulfilled(): bool
    {
        return $this->getState() === StatusInterface::STATE_FULFILLED;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getState();
    }
}
