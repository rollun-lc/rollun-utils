<?php

declare(strict_types=1);

namespace rollun\Marketplace\Interfaces;

/**
 * Interface PriceInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface PriceInterface
{
    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency(): string;

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount(): float;
}
