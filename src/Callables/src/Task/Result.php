<?php
declare(strict_types=1);

namespace rollun\Callables\Task;

use rollun\Callables\Task\Async\Result\Data\TaskInfoInterface;

/**
 * Class Result
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class Result extends ErrorResult implements ResultInterface
{
    /**
     * @var null|ToArrayForDtoInterface
     */
    protected $data;

    /**
     * Result constructor.
     *
     * @param null|ToArrayForDtoInterface $data
     * @param array                       $messages
     */
    public function __construct(?ToArrayForDtoInterface $data, array $messages = [])
    {
        parent::__construct($messages);

        $this->data = $data;
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
    public function toArrayForDto(): array
    {
        $result = parent::toArrayForDto();
        $result['data'] = !empty($data = $this->getData()) ? $data->toArrayForDto() : null;

        return $result;
    }
}
