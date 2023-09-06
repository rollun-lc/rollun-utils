<?php


namespace Unit\Utils\FileCleaner;


use PHPUnit\Framework\TestCase;
use rollun\utils\Cleaner\CleanableList\FileCleanableList;
use rollun\utils\Cleaner\Cleaner;
use rollun\utils\Cleaner\CleaningValidator\FileValidatorTime;

class CleanFileTest extends TestCase
{
    const VALID_FILES_COUNT = 4;
    const INVALID_FILE_COUNT = 3;
    const MIN_VALID_TIME  = '-10 days';

    protected $dir;

    protected function setUp()
    {
        $dir = 'data' . DIRECTORY_SEPARATOR . 'list';
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        $this->dir = realpath($dir);
        $this->createTempFiles($dir);
    }

    protected function tearDown()
    {
        $this->removeTempFiles($this->dir);
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

    protected function createTempFiles($dir)
    {
        for ($i = 1; $i <= self::VALID_FILES_COUNT; $i++) {
            $name = $dir . DIRECTORY_SEPARATOR . 'valid-' . $i . '.txt';
            touch($name);
        }

        $dateTime = new \DateTime(self::MIN_VALID_TIME);
        $dateTime->modify('-1 seconds');
        for ($i = 1; $i <= self::INVALID_FILE_COUNT; $i++) {
            $name = $dir . DIRECTORY_SEPARATOR . 'invalid-' . $i . '.txt';
            touch($name, $dateTime->getTimestamp());
        }
    }

    public function testCleanFile()
    {
        $cleanableList = new FileCleanableList($this->dir);
        $cleaningValidator = new FileValidatorTime(self::MIN_VALID_TIME);
        $cleaner = new Cleaner($cleanableList, $cleaningValidator);
        $cleaner->cleanList();

        $this->assertEquals(4, count(glob($this->dir . '/valid-*.txt')));
        $this->assertEmpty(glob($this->dir . '/invalid-*.txt'));
    }
}