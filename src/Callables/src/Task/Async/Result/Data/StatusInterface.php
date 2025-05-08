<?php

declare(strict_types=1);

namespace rollun\Callables\Task\Async\Result\Data;

use rollun\Callables\Task\ToArrayForDtoInterface;

/**
 * Interface AsyncStatusInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface StatusInterface extends ToArrayForDtoInterface
{
    public const STATE_PENDING = 'pending';
    public const STATE_FULFILLED = 'fulfilled';
    public const STATE_REJECTED = 'rejected';

    /**
     * Get current state
     *
     * @return string
     */
    public function getState(): string;

    /**
     * Get allowed states
     *
     * @return string[]
     */
    public function getAllStates(): array;

    /**
     * Is current state pending?
     *
     * @return bool
     */
    public function isPending(): bool;

    /**
     * Is current state reject?
     *
     * @return bool
     */
    public function isRejected(): bool;

    /**
     * Switch state to reject
     */
    public function toReject(): void;

    /**
     * Is current state fulfilled?
     *
     * @return bool
     */
    public function isFulfilled(): bool;

    /**
     * Switch state to fulfilled
     */
    public function toFulfilled(): void;

    /**
     * Get current state
     *
     * @return string
     */
    public function __toString(): string;
}
