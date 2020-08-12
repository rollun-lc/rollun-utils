<?php


namespace rollun\LongTermTask\Interfaces\Results\Task;


use rollun\LongTermTask\Interfaces\Results\ResultInterface;

interface TaskTypeListResultInterface extends ResultInterface
{
    /**
     * @return string[]
     */
    public function getData();
}