<?php
declare(strict_types=1);

namespace rollun\callback\LongTermTask\Interfaces\Results;


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
     * Return true if messages is null
     * @return bool
     */
    public function isSuccess(): bool;
}
