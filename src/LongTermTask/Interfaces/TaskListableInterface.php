<?php


namespace rollun\callback\LongTermTask\Interfaces;


interface TaskListableInterface extends TaskCollectionInterface
{
    /**
     * Return exists tasks id
     *
     * @return array
     */
    public function getTaskIdList(): array;
}