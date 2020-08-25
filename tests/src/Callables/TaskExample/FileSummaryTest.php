<?php
declare(strict_types=1);

namespace rollun\test\utils\Callables\TaskExample;

use rollun\Callables\TaskExample\FileSummary;
use rollun\Callables\TaskExample\Model\CreateTaskParameters;

/**
 * Class FileSummaryTest
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class FileSummaryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return array
     */
    public function getFileSummaryInfoDataProvider(): array
    {
        return [
            ['1', 'summary calculating', 'pending', 1],
            ['2', 'done', 'fulfilled', 3],
            ['5', 'done', 'fulfilled', 6],
            ['6', 'writing 4', 'pending', 3],
            ['7', 'writing 2', 'pending', 1],
        ];
    }

    /**
     * @param string $n
     * @param string $stage
     * @param string $status
     * @param int    $wait
     *
     * @dataProvider getFileSummaryInfoDataProvider
     */
    public function testFileSummaryInfo(string $n, string $stage, string $status, int $wait)
    {
        // create task
        exec("php bin/task-example/create.php $n >/dev/null 2>&1 &");

        sleep($wait);
        $result = (new FileSummary())->getTaskInfoById($n);

        $this->assertEquals(['stage' => $stage, 'status' => $status], ['stage' => $result->getData()->getStage(), 'status' => (string)$result->getStatus()]);
    }

    /**
     * @return array
     */
    public function getFileSummaryResultDataProvider(): array
    {
        return [
            ['1', 1, 0],
            ['2', 3, 3],
            ['5', 6, 15],
        ];
    }

    /**
     * @param string $n
     * @param int    $wait
     * @param int    $expectedSummary
     *
     * @dataProvider getFileSummaryResultDataProvider
     */
    public function testFileSummaryResult(string $n, int $wait, int $expectedSummary)
    {
        // create task
        exec("php bin/task-example/create.php $n >/dev/null 2>&1 &");

        sleep($wait);
        $result = (new FileSummary())->getTaskResultById($n);

        $this->assertEquals($expectedSummary, empty($result->getData()) ? 0 : $result->getData()->getSummary());
    }


    /**
     * Tests for error messages
     */
    public function testMessages()
    {
        $this->assertEquals('No such task', (new FileSummary())->getTaskInfoById('122')->getMessages()[0]->getText());

        $this->assertEquals('No such task result', (new FileSummary())->getTaskResultById('122')->getMessages()[0]->getText());

        exec("php bin/task-example/create.php 20 >/dev/null 2>&1 &");
        sleep(1);
        $this->assertEquals('Such task is already exists', (new FileSummary())->runTask(new CreateTaskParameters(20))->getMessages()[0]->getText());
    }
}
