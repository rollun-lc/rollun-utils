<?php
declare(strict_types=1);

namespace rollun\Callables\Marketplace\Interfaces;

use rollun\Callables\Marketplace\Interfaces\Results\OrderInfoResultInterface;
use rollun\Callables\Marketplace\Interfaces\Results\OrdersInfoResultInterface;

/**
 * Interface OrderCollectionInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface OrderCollectionInterface
{
    const MAX_DAYS = PHP_INT_MAX - 1;

    /**
     * Get orders by number of days passed
     *
     * @param int $days
     *
     * @return OrdersInfoResultInterface
     */
    public function getOrdersByDaysPassed(int $days = self::MAX_DAYS): OrdersInfoResultInterface;

    /**
     * Get order info by id
     *
     * @param string $id
     *
     * @return OrderInfoResultInterface
     */
    public function getOrderInfoById(string $id): OrderInfoResultInterface;
}