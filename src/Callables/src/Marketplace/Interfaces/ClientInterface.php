<?php
declare(strict_types=1);

namespace rollun\Callables\Marketplace\Interfaces;

/**
 * Interface ClientInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface ClientInterface
{
    /**
     * GEt client id
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Get client name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get client email
     *
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * Get client phone
     *
     * @return string|null
     */
    public function getPhone(): ?string;
}
