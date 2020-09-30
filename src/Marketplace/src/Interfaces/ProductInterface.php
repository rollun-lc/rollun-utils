<?php
declare(strict_types=1);

namespace rollun\Marketplace\Interfaces;

/**
 * Interface ProductInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface ProductInterface
{
    /**
     * Get sku
     *
     * @return string
     */
    public function getSku(): string;

    /**
     * @return string|null
     */
    public function getMsin(): ?string;

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string;
}
