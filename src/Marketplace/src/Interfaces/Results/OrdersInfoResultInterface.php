<?php
declare(strict_types=1);

namespace rollun\Marketplace\Interfaces\Results;

use rollun\Callables\Results\Interfaces\ResultInterface;
use rollun\Marketplace\Interfaces\OrderInterface;

/**
 * Interface OrdersInfoResultInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface OrdersInfoResultInterface extends ResultInterface
{
    /**
     * Get orders data
     *
     * @return OrderInterface[]|null
     */
    public function getData();
}
