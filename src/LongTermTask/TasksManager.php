<?php


namespace rollun\callback\LongTermTask;


use rollun\callback\LongTermTask\Interfaces\TaskCollectionInterface;
use rollun\callback\LongTermTask\Interfaces\TasksManagerInterface;
use rollun\callback\LongTermTask\Interfaces\TaskTypeInfoInterface;

class TasksManager implements TasksManagerInterface
{
    /**
     * @var TaskCollectionInterface[]
     */
    private $taskCollectionList;

    /**
     * $tasksCollectionList list of TaskCollection, indexed by TaskType -> [TaskType => TaskCollection]
     *
     * FIXME: in future array changed by objects for create registered new task types.
     * @param array $taskCollectionList
     */
    public function __construct(array $taskCollectionList)
    {
        $this->taskCollectionList = $taskCollectionList;
    }

    /**
     * Return list of tasks type
     * @return string[]
     */
    public function getTaskTypeList(): array
    {
        return array_keys($this->taskCollectionList);
    }

    /**
     * Return TaskType info
     *
     * @param string $taskType
     * @return TaskTypeInfoInterface
     */
    public function getTaskTypeInfoByTaskType(string $taskType): TaskTypeInfoInterface
    {
        if (!isset($this->taskCollectionList[$taskType])) {
            throw new \InvalidArgumentException("TaskType `$taskType` is not valid.");
        }
        return $this->taskCollectionList[$taskType]->getTaskTypeInfo();
    }

}