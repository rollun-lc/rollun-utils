<?php


namespace rollun\callback\LongTermTask\Interfaces\Results\Task;


/**
 * Interface CreateTaskResultInterface
 * @package rollun\callback\LongTermTask\Interfaces\Results\Task
 */
interface CreateTaskResultInterface extends TaskInfoResultInterface
{
    /**
     * Return created task id
     * @return string
     */
    public function getData();


}