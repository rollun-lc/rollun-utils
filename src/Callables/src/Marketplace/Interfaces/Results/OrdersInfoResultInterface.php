<?php
declare(strict_types=1);

namespace rollun\Callables\Marketplace\Interfaces\Results;

use rollun\Callables\Results\Interfaces\ResultInterface;

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
     * @return OrderInfoInterface[]|null
     */
    public function getData();
}
