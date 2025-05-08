<?php

declare(strict_types=1);

namespace rollun\Marketplace\Interfaces\Results;

use rollun\Callables\Results\Interfaces\ResultInterface;
use rollun\Callables\Status\Interfaces\Async\StatusInterface;

/**
 * Interface StatusResultInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface StatusResultInterface extends ResultInterface
{
    /**
     * @return StatusInterface
     */
    public function getData();
}
