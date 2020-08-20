<?php
declare(strict_types=1);

namespace rollun\Callables\Status\Interfaces\Async;

use rollun\Callables\Status\Interfaces\StatusInterface as SyncStatusInterface;

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
