<?php
declare(strict_types=1);

namespace rollun\Callables\Task;

use rollun\Callables\Task\Result\MessageInterface;
use rollun\Callables\Task\Result\StatusInterface;

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
     * Add message
     *
     * @param MessageInterface $message
     */
    public function addMessage(MessageInterface $message): void;

    /**
     * Get current status
     *
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface;
}
