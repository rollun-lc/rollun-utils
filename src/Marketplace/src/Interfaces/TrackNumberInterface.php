<?php

declare(strict_types=1);

namespace rollun\Marketplace\Interfaces;

use rollun\Callables\Results\Interfaces\ResultInterface;
use rollun\Marketplace\Interfaces\Results\PayloadResultInterface;
use rollun\Marketplace\Interfaces\Results\StatusResultInterface;

/**
 * interface TrackNumberInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TrackNumberInterface
{
    /**
     * Is track number set ?
     *
     * @param string $orderId
     * @param string $trackNumber
     *
     * @return ResultInterface
     */
    public function isTrackNumberSet(string $orderId, string $trackNumber): ResultInterface;

    /**
     * Update track number
     *
     * @param string      $orderId
     * @param string      $trackNumber
     * @param string      $carrier
     * @param \DateTime   $shippingDate UTC only
     * @param array       $orderItems
     * @param string|null $shippingMethod
     *
     * @return StatusResultInterface|PayloadResultInterface
     */
    public function updateTrackNumber(string $orderId, string $trackNumber, string $carrier, \DateTime $shippingDate, array $orderItems, string $shippingMethod = null);
}
