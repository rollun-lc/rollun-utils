<?php
declare(strict_types=1);

namespace rollun\LongTermTask\Interfaces;

/**
 * Interface TaskListableInterface
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
interface TaskListableInterface extends TaskCollectionInterface
{
    /**
     * Return exists tasks id
     *
     * @return array
     */
    public function getTaskIdList(): array;
}