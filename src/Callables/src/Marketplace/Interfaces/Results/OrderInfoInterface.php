<?php
declare(strict_types=1);

namespace rollun\Callables\Marketplace\Interfaces\Results;

/**
 * Interface OrderInfoInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface OrderInfoInterface
{
    /**
     * Get order id
     *
     * @return string
     */
    public function getId(): string;
}
