<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Async\Result;

use rollun\Callables\Task\Result\StatusInterface as SyncStatusInterface;

/**
 * Interface AsyncStatusInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface StatusInterface extends SyncStatusInterface
{
    const STATE_PENDING = 'pending';

    /**
     * @return bool
     */
    public function isPending(): bool;

    /**
     * Switch state to reject
     */
    public function toReject(): void;

    /**
     * Switch state to fulfilled
     */
    public function toFulfilled(): void;
}
