<?php


namespace rollun\utils\Cleaner\CleanableList;

/**
 * Class FileCleanableList
 * @package rollun\utils\Cleaner\CleanableList
 */
class FileCleanableList implements \IteratorAggregate, CleanableListInterface
{
    /**
     * @var string
     */
    protected $dirName;

    /**
     * FileCleanableList constructor.
     * @param string $dirName
     */
    public function __construct($dirName)
    {
        $this->dirName = $dirName;
    }

    /**
     * @param $fileName
     */
    public function deleteItem($fileName)
    {
        unlink($fileName);
    }

    /**
     * @return \Generator|\Traversable
     */
    public function getIterator()
    {
        $iterator = new \DirectoryIterator($this->dirName);
        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }

            yield $file->getPathname();
        }
    }
}