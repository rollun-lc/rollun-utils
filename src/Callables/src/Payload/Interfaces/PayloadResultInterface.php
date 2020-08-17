<?php
declare(strict_types=1);

namespace rollun\Callables\Payload\Interfaces;

use rollun\Callables\Results\Interfaces\ResultInterface;

/**
 * Interface PayloadResultInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface PayloadResultInterface extends ResultInterface
{
    /**
     * @return PayloadInterface|null
     */
    public function getData();
}
