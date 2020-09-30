<?php
declare(strict_types=1);

namespace rollun\Marketplace\Interfaces;

/**
 * Interface OrderItemInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface OrderItemInterface
{
    /**
     * Get item id
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Get product
     *
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface;

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity(): float;

    /**
     * Get product price
     *
     * @return PriceInterface
     */
    public function getProductPrice(): PriceInterface;

    /**
     * Get shipping method
     *
     * @return string
     */
    public function getShippingMethod(): string;

    /**
     * Get shipping price
     *
     * @return PriceInterface
     */
    public function getShippingPrice(): PriceInterface;

    /**
     * Get ship date
     *
     * @return \DateTime
     */
    public function getShipDate(): \DateTime;

    /**
     * Get delivery date
     *
     * @return \DateTime|null
     */
    public function getDeliveryDate(): ?\DateTime;
}
