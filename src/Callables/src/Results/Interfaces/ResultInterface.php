<?php
declare(strict_types=1);

namespace rollun\Callables\Results\Interfaces;

use rollun\Callables\Status\Interfaces\StatusInterface;

/**
 * Interface ResultInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface ResultInterface
{
    /**
     * Get data
     *
     * @return mixed
     */
    public function getData();

    /**
     * Get messages
     *
     * @return MessageInterface[]|null
     */
    public function getMessages(): ?array;

    /**
     * Get current status
     *
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface;
}
