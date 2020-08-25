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
            ['1', 'summary calculating', 'pending', 1, 1],
            ['2', 'done', 'fulfilled', 3, 3],
            ['5', 'done', 'fulfilled', 6, 15],
            ['6', 'writing 4', 'pending', 3, 6],
            ['7', 'writing 2', 'pending', 1, 1],
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

        $this->assertEquals($stage, $result->getData()->getStage());
        $this->assertEquals($status, (string)$result->getData()->getResult()->getStatus());
        $this->assertEquals($summary, $result->getData()->getResult()->getData()->getSummary());
    }

    /**
     * Tests for error messages
     */
    public function testMessages()
    {
        $this->assertEquals('No such task', (new FileSummary())->getTaskInfoById('122')->getMessages()[0]->getText());

        $this->assertEquals('n param should be more than 1', (new FileSummary())->runTask(new CreateTaskParameters(-10))->getMessages()[0]->getText());

        $this->createTask(20);
        sleep(1);
        $this->assertEquals('Such task is already exists', (new FileSummary())->runTask(new CreateTaskParameters(20))->getMessages()[0]->getText());
    }

    /**
     * Tests for delete method
     */
    public function testDelete()
    {
        $this->assertEquals('No such task', (new FileSummary())->deleteById('55')->getMessages()[0]->getText());

        $this->assertEquals(false, (new FileSummary())->deleteById('55')->getData()->getIsDeleted());

        $this->createTask(2);
        sleep(3);
        $this->assertEquals(true, (new FileSummary())->deleteById('2')->getData()->getIsDeleted());
    }

    /**
     * @param int $n
     */
    protected function createTask(int $n)
    {
        $file = FileSummary::DIR_PATH . '/' . $n . '.json';
        if (file_exists($file)) {
            unlink($file);
        }

        exec("php bin/task-example/create.php $n >/dev/null 2>&1 &");
    }
}
