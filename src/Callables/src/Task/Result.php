<?php
declare(strict_types=1);

namespace rollun\Callables\Task;

/**
 * Class Result
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class Result extends ErrorResult implements ResultInterface
{
    /**
     * @var array|null
     */
    protected $data;

    /**
     * Result constructor.
     *
     * @param array|null $data
     * @param array      $messages
     */
    public function __construct(?array $data, array $messages = [])
    {
        parent::__construct($messages);

        $this->setData($data);
    }

    /**
     * @inheritDoc
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     */
    public function setData(?array $data): void
    {
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function toArrayForDto(): array
    {
        $result = parent::toArrayForDto();
        $result['data'] = $this->getData();

        return $result;
    }
}
