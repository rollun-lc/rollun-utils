<?php
declare(strict_types=1);

namespace rollun\Marketplace\Interfaces\Results;

use rollun\utils\Interfaces\Results\ResultInterface;

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
