<?php
declare(strict_types=1);

namespace rollun\Marketplace\Interfaces;

/**
 * Interface ClientInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface ClientInterface
{
    /**
     * Get client email
     *
     * @return string
     */
    public function getEmail(): string;

    /**
     * Get client id
     *
     * @return string|null
     */
    public function getId(): ?string;

    /**
     * Get client name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Get client phone
     *
     * @return string|null
     */
    public function getPhone(): ?string;
}
