<?php

namespace rollun\utils\Cleaner\Example\DirCleaner;

use rollun\utils\Cleaner\CleanableList\CleanableListInterface;

class FilesList implements \IteratorAggregate, CleanableListInterface
{

    public function __construct(protected $dirName) {}

    public function deleteItem($fileName)
    {
        unlink($fileName);
    }

    public function getIterator()
    {
        $filesInfoList = $this->getFilesList($this->dirName);
        return new \ArrayIterator($filesInfoList);
    }

    protected function getFilesList($dirName)
    {
        // array to hold return value
        $filesList = [];
        // open directory for reading
        $dirIterator = new \DirectoryIterator($dirName) or die("getFileList: Failed opening directory $dirName for reading");
        foreach ($dirIterator as $fileInfo) {
            if ($fileInfo->isFile()) {
                $filesList[] = $this->dirName . $fileInfo->getFilename();
            }
        }
        return $filesList;
    }

}
