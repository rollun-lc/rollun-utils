<?php


namespace rollun\callback\LongTermTask\Interfaces\Results\Task;


/**
 * Interface CreateTaskResultInterface
 * @package rollun\callback\LongTermTask\Interfaces\Results\Task
 */
interface DeletedTaskResultInterface extends TaskInfoResultInterface
{
    /**
     * Return count of deleted task
     * @return int
     */
    public function getData();


}