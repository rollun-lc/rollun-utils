<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Async;

use rollun\Callables\Task\Async\Result\StatusInterface;

/**
 * Interface ResultInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface ResultInterface extends \rollun\Callables\Task\ResultInterface
{
    /**
     * Get current status
     *
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface;
}
