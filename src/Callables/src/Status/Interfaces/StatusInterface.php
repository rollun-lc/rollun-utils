<?php
declare(strict_types=1);

namespace rollun\Callables\Status\Interfaces;

/**
 * Interface StatusInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface StatusInterface
{
    const STATE_PENDING = 'pending';
    const STATE_FULFILLED = 'fulfilled';
    const STATE_REJECTED = 'rejected';

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @return bool
     */
    public function isPending(): bool;

    /**
     * @return bool
     */
    public function isRejected(): bool;

    /**
     * Switch state to reject
     */
    public function toReject(): void;

    /**
     * @return bool
     */
    public function isFulfilled(): bool;

    /**
     * Switch state to fulfilled
     */
    public function toFulfilled(): void;

    /**
     * @return string
     */
    public function __toString(): string;
}
