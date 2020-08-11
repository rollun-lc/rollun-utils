<?php


namespace rollun\LongTermTask\Interfaces\Results\Task;


/**
 * Interface CreateTaskResultInterface
 * @package rollun\LongTermTask\Interfaces\Results\Task
 */
interface DeletedTaskResultInterface extends TaskInfoResultInterface
{
    /**
     * Return count of deleted task
     * @return int
     */
    public function getData();

}