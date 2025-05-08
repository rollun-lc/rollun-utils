<?php

declare(strict_types=1);

namespace rollun\Marketplace\Interfaces\Results;

use rollun\Callables\Results\Interfaces\ResultInterface;
use rollun\Marketplace\Interfaces\OrderInterface;

/**
 * Interface OrderInfoResultInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface OrderInfoResultInterface extends ResultInterface
{
    /**
     * Get order data
     *
     * @return OrderInterface|null
     */
    public function getData();
}
