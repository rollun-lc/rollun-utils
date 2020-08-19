<?php
declare(strict_types=1);

namespace rollun\Callables\Marketplace\Interfaces;

/**
 * Interface OrderInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface OrderInterface
{
    /**
     * Get order id
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Get order status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Get order shipping address
     *
     * @return AddressInterface
     */
    public function getShippingAddress(): AddressInterface;

    /**
     * Get client interface
     *
     * @return ClientInterface
     */
    public function getClient(): ClientInterface;

    /**
     * Get order items
     *
     * @return OrderItemInterface[]
     */
    public function getItems(): array;

    /**
     * Get order date
     *
     * @return \DateTime UTC only
     */
    public function getOrderDate(): \DateTime;

    /**
     * Get order amount
     *
     * @return PriceInterface
     */
    public function getOrderAmount(): PriceInterface;
}
