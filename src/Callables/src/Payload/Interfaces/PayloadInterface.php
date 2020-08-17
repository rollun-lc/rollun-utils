<?php
declare(strict_types=1);

namespace rollun\Callables\Payload\Interfaces;

/**
 * Interface PayloadInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface PayloadInterface
{
    /**
     * Return unique id of payload
     *
     * @return mixed
     */
    public function getId(): string;

    /**
     * @return array
     */
    public function getPayload(): array;

    /**
     * @param array $payload
     *
     * @return void
     */
    public function setPayload(array $payload): void;
}
