<?php
declare(strict_types=1);

namespace rollun\Callables\Marketplace\Interfaces;

/**
 * Interface AddressInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface AddressInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getAddressLine1(): string;

    /**
     * @return string|null
     */
    public function getAddressLine2(): ?string;

    /**
     * @return string
     */
    public function getCity(): string;

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @return string
     */
    public function getPostalCode(): string;

    /**
     * @return string|null
     */
    public function getPhone(): ?string;
}
