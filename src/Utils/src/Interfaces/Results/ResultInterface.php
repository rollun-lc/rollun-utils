<?php
declare(strict_types=1);

namespace rollun\utils\Interfaces\Results;

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
     * Return false if there are at least one message with level 'error'
     *
     * @return bool
     */
    public function isSuccess(): bool;
}
