<?php


namespace rollun\test\utils\FileCleaner;


use PHPUnit\Framework\TestCase;
use rollun\utils\Cleaner\CleanableList\FileCleanableList;

class FileCleanableListTest extends TestCase
{
    protected const FILES_COUNT = 5;
    protected const DIRS_COUNT = 2;

    protected $dir;

    protected function setUp(): void
    {
        $dir = 'data' . DIRECTORY_SEPARATOR . 'list';
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        $this->dir = realpath($dir);
        $this->createTempFiles($dir);
        $this->createTempDirs($dir);
    }

    protected function tearDown(): void
    {
        $this->removeTempFiles($this->dir);
    }

    protected function createTempDirs($dir)
    {
        for ($i = 1; $i <= self::DIRS_COUNT; $i++) {
            if (!file_exists($dir . DIRECTORY_SEPARATOR . $i)) {
                mkdir($dir . DIRECTORY_SEPARATOR . $i);
            }
            $this->createTempFiles($dir . DIRECTORY_SEPARATOR . $i);
        }
    }

    protected function createTempFiles($dir)
    {
        for ($i = 1; $i <= self::FILES_COUNT; $i++) {
            touch($dir . DIRECTORY_SEPARATOR . $i . '.txt');
        }
    }

    protected function removeTempFiles($dir)
    {
        foreach (scandir($dir) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_file($path)) {
                unlink($path);
            } else {
                $this->removeTempFiles($path);
            }
        }
        rmdir($dir);
    }

    public function testList()
    {
        $cleanableList = new FileCleanableList($this->dir);
        foreach ($cleanableList as $file) {
            $files[] = $file;
        }

       $this->assertEquals(self::FILES_COUNT, count($files));
    }
}