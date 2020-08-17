<?php
declare(strict_types=1);

namespace rollun\utils\Results;

/**
 * Interface MessageInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface MessageInterface
{
    /**
     * Get level og message
     *
     * @return string
     */
    public function getLevel(): string;

    /**
     * Get message text
     *
     * @return string
     */
    public function getText(): string;

    /**
     * Get message context (like in a logger)
     *
     * @return array|null
     */
    public function getContext(): ?array;
}
