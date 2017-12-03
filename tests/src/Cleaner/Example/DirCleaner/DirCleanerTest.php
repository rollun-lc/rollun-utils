<?php

namespace rollun\test\utils\Cleaner\Example\DirCleaner;

use rollun\utils\Cleaner\Example\DirCleaner\CleanRuner;

class DirCleanerTest extends \PHPUnit\Framework\TestCase
{

    public function test_DirCleaner()
    {
        $cleanRuner = new CleanRuner;
        //5 files with size 1 ,3 ,5 ,7 and 9 bytes have made in folder 'data/cleanIt'
        $this->assertFileExists($cleanRuner->fullPath . "1.txt");
        $this->assertFileExists($cleanRuner->fullPath . "9.txt");


        $cleanRuner->deleteBigFiles(4); //max file size - 4bytes
        //only 1.txt and 3.txt now exist
        $this->assertFileExists($cleanRuner->fullPath . "1.txt");
        $this->assertFileNotExists($cleanRuner->fullPath . "9.txt");
    }

}
