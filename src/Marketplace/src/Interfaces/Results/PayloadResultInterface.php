<?php
declare(strict_types=1);

namespace rollun\Marketplace\Interfaces\Results;

use rollun\Callables\Results\Interfaces\ResultInterface;
use rollun\Marketplace\Interfaces\PayloadInterface;

/**
 * Interface PayloadResultInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface PayloadResultInterface extends ResultInterface
{
    /**
     * @return PayloadInterface|null
     */
    public function getData();
}
