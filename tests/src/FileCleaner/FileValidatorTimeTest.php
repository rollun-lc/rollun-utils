<?php


namespace rollun\test\utils\FileCleaner;


use PHPUnit\Framework\TestCase;
use rollun\utils\Cleaner\CleaningValidator\FileValidatorTime;

class FileValidatorTimeTest extends TestCase
{
    protected $file;

    protected function setUp()
    {
        $file = 'data' . DIRECTORY_SEPARATOR . 'test_file';
        touch($file);
        $this->file = realpath($file);
        file_put_contents($this->file, 'test');
    }

    protected function tearDown()
    {
        unlink($this->file);
    }

    public function testValid()
    {
        $validator = new FileValidatorTime(new \DateTime('-5 minutes'));
        $this->assertTrue($validator->isValid($this->file));
    }

    public function testInvalid()
    {
        sleep(2);

        $validator = new FileValidatorTime(new \DateTime('-1 seconds'));
        $this->assertFalse($validator->isValid($this->file));
    }
}