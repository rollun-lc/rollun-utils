<?php
declare(strict_types=1);

namespace rollun\Callables\Task;

use Psr\Log\LogLevel;
use rollun\Callables\Task\Result\Message;
use rollun\Callables\Task\Result\MessageInterface;

/**
 * Class ErrorResult
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class ErrorResult implements ErrorResultInterface
{
    /**
     * @var MessageInterface[]
     */
    protected $messages;

    /**
     * ErrorResult constructor.
     *
     * @param array $messages
     */
    public function __construct(array $messages = [])
    {
        foreach ($messages as $message) {
            $this->addMessage($message);
        }
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
    public function addMessage($message): void
    {
        // create message from array
        if (is_array($message) && !empty($message['level']) && !empty($message['text'])) {
            $message = new Message($message['level'], $message['text'], empty($message['context']) ? [] : $message['context']);
        }

        if (!$message instanceof MessageInterface) {
            throw new \InvalidArgumentException(MessageInterface::class . ' expected');
        }

        $this->messages[] = $message;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        foreach ($this->getMessages() as $message) {
            if ($message->getLevel() == LogLevel::ERROR) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function toArrayForDto(): array
    {
        // get messages
        $messages = empty($this->getMessages()) ? [] : $this->getMessages();

        $result = [];
        foreach ($messages as $message) {
            $result[] = $message->toArrayForDto();
        }

        return [
            'messages' => $result,
        ];
    }
}
