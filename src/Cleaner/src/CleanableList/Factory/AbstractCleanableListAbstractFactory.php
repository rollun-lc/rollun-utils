<?php

namespace rollun\utils\Cleaner\CleanableList\Factory;

use rollun\utils\Cleaner\CleanableList\CleanableListInterface;
use rollun\utils\Factory\AbstractAbstractFactory;

/**
 * Class AbstractCleanableListAbstractFactory
 * @package rollun\utils\Cleaner\CleanableList\Factory
 */
abstract class AbstractCleanableListAbstractFactory extends AbstractAbstractFactory
{
    const KEY = AbstractCleanableListAbstractFactory::class;

    const DEFAULT_CLASS = CleanableListInterface::class;

}