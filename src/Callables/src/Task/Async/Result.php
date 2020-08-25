<?php
declare(strict_types=1);

namespace rollun\Callables\Task\Async;

use rollun\Callables\Task\Async\Result\StatusInterface;

/**
 * Class Result
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class Result extends \rollun\Callables\Task\Result implements ResultInterface
{
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
        parent::__construct($data, $messages);

        $this->status = $status;
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): StatusInterface
    {
        return $this->status;
    }
}
