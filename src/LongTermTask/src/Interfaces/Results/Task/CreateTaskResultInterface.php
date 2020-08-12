<?php


namespace rollun\LongTermTask\Interfaces\Results\Task;


/**
 * Interface CreateTaskResultInterface
 * @package rollun\LongTermTask\Interfaces\Results\Task
 */
interface CreateTaskResultInterface extends TaskInfoResultInterface
{
    /**
     * Return created task id
     * @return string
     */
    public function getData();
}