<?php

declare(strict_types=1);

namespace rollun\Callables\Task\Result;

/**
 * Class Message
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class Message implements MessageInterface
{
    /**
     * @var string
     */
    protected $level;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var array
     */
    protected $context;

    /**
     * Message constructor.
     *
     * @param string $level
     * @param string $text
     * @param array  $context
     */
    public function __construct(string $level, string $text, array $context = [])
    {
        $this->level = $level;
        $this->text = $text;
        $this->context = $context;
    }

    /**
     * @inheritDoc
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @inheritDoc
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function getContext(): ?array
    {
        return $this->context;
    }

    /**
     * @inheritDoc
     */
    public function toArrayForDto(): array
    {
        return [
            'level'   => $this->getLevel(),
            'text'    => $this->getText(),
            'context' => $this->getContext(),
        ];
    }
}
