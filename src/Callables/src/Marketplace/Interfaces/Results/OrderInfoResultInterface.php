<?php
declare(strict_types=1);

namespace rollun\Callables\Marketplace\Interfaces\Results;

use rollun\Callables\Results\Interfaces\ResultInterface;

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
     * @return OrderInfoInterface|null
     */
    public function getData();
}
