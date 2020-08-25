<?php
declare(strict_types=1);

namespace rollun\Callables\TaskExample;

use rollun\Callables\Task\Async\Result\TaskInfoInterface;

/**
 * Class Result
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class Result extends \rollun\Callables\Task\Result implements TaskInfoInterface
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        return parent::getData();
    }
}
