<?php
declare(strict_types=1);

namespace Unit\Utils\Callables\TaskExample;

use rollun\Callables\TaskExample\FileSummary;

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
            ['1', 'done', 'fulfilled', 1, 1],
            ['3', 'writing 3', 'pending', 1, 3],
            ['5', 'done', 'fulfilled', 6, 15],
            ['6', 'writing 5', 'pending', 3, 10],
            ['7', 'writing 3', 'pending', 1, 3],
        ];
    }

    /**
     * @param string $n
     * @param string $stage
     * @param string $status
     * @param int    $wait
     * @param int    $summary
     *
     * @dataProvider getFileSummaryInfoDataProvider
     */
    public function testFileSummaryInfo(string $n, string $stage, string $status, int $wait, int $summary)
    {
        // create task
        $this->createTask((int)$n);

        sleep($wait);
        $result = (new FileSummary())->getTaskInfoById($n);

        $this->assertEquals($stage, (string)$result->getData()['stage']['stage']);
        $this->assertEquals($status, (string)$result->getData()['status']['state']);
        $this->assertEquals($summary, $result->getData()['result']['data']['summary']);
    }

    /**
     * Tests for error messages
     */
    public function testMessages()
    {
        $this->assertEquals('No such task', (new FileSummary())->getTaskInfoById('122')->getMessages()[0]->getText());

        $this->assertEquals('n param should be more than 1', $this->createTask(-10)->getMessages()[0]->getText());

        $this->createTask(20);
        sleep(1);
        $this->assertEquals('Such task is already exists', $this->createTask(20)->getMessages()[0]->getText());
    }

    /**
     * Tests for delete method
     */
    public function testDelete()
    {
        $this->assertEquals('No such task', (new FileSummary())->deleteById('55')->getMessages()[0]->getText());

        $this->assertEquals(false, (new FileSummary())->deleteById('55')->getData()['isDeleted']);

        $this->createTask(2);
        sleep(3);
        $this->assertEquals(true, (new FileSummary())->deleteById('2')->getData()['isDeleted']);
    }

    /**
     * @param int $n
     */
    protected function createTask(int $n)
    {
        $data = new \stdClass();
        $data->n = $n;

        return (new FileSummary())->runTask($data);
    }
}
