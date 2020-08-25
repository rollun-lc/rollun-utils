<?php
declare(strict_types=1);

namespace rollun\Callables\Task;

use rollun\Callables\Task\Async\Result\TaskInfoInterface;
use rollun\Callables\Task\Result\StatusInterface;
use rollun\Callables\Task\Result\MessageInterface;

/**
 * Class Result
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class Result implements ResultInterface
{
    /**
     * @var TaskInfoInterface
     */
    protected $data;

    /**
     * @var MessageInterface[]
     */
    protected $messages;

    /**
     * @var StatusInterface
     */
    protected $status;

    /**
     * Result constructor.
     *
     * @param null|object     $data
     * @param StatusInterface $status
     * @param array           $messages
     */
    public function __construct($data, StatusInterface $status, array $messages = [])
    {
        $this->data = $data;
        $this->status = $status;
        $this->messages = $messages;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function getMessages(): ?array
    {
        return $this->messages;
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): StatusInterface
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function addMessage(MessageInterface $message): void
    {
        $this->messages[] = $message;
    }
}
