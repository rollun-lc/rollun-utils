<?php


namespace rollun\callback\LongTermTask\Interfaces\Results\Task;


use rollun\callback\LongTermTask\Interfaces\Results\ResultInterface;

interface TaskTypeListResultInterface extends ResultInterface
{
    /**
     * @return string[]
     */
    public function getData();
}