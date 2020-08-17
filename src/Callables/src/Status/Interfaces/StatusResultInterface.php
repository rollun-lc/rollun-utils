<?php
declare(strict_types=1);

namespace rollun\Callables\Status\Interfaces;

use rollun\Callables\Results\ResultInterface;

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
