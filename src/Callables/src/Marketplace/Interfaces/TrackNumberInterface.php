<?php
declare(strict_types=1);

namespace rollun\Callables\Marketplace\Interfaces;

use rollun\Callables\Payload\Interfaces\PayloadResultInterface;
use rollun\Callables\Results\ResultInterface;
use rollun\Callables\Status\Interfaces\StatusResultInterface;

/**
 * interface TrackNumberInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TrackNumberInterface
{
    /**
     * Is track number updated ?
     *
     * @param string $orderId
     * @param string $trackNumber
     *
     * @return ResultInterface
     */
    public function isTrackNumberUpdated(string $orderId, string $trackNumber): ResultInterface;

    /**
     * Update track number
     *
     * @param string    $orderId
     * @param string    $trackNumber
     * @param string    $carrier
     * @param string    $shippingMethod
     * @param \DateTime $shippingDate UTC only
     * @param array     $orderItems
     *
     * @return StatusResultInterface|PayloadResultInterface
     */
    public function updateTrackNumber(string $orderId, string $trackNumber, string $carrier, string $shippingMethod, \DateTime $shippingDate, array $orderItems);
}