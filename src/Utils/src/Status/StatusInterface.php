<?php
declare(strict_types=1);

namespace rollun\utils\Status;

/**
 * Interface StatusInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface StatusInterface
{
    const STATE_PENDING = 'PENDING';
    const STATE_FULFILLED = 'FULFILLED';
    const STATE_REJECTED = 'REJECTED';

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @param string $state
     *
     * @return void
     */
    public function setState(string $state): void;

    /**
     * @return bool
     */
    public function isPending(): bool;

    /**
     * @return bool
     */
    public function isRejected(): bool;

    /**
     * @return bool
     */
    public function isFulfilled(): bool;

    /**
     * @return string
     */
    public function __toString(): string;
}
