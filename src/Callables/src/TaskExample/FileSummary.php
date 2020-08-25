<?php
declare(strict_types=1);

namespace rollun\Callables\TaskExample;

use rollun\Callables\Task\Async\Result\Status;
use rollun\Callables\Task\Async\Result\TaskInfoInterface;
use rollun\Callables\Task\Async\TaskInterface;
use rollun\Callables\Task\Result;
use rollun\Callables\Task\Result\Message;
use rollun\Callables\Task\ResultInterface;
use rollun\Callables\TaskExample\Model\CreateTaskParameters;
use rollun\Callables\TaskExample\Result\Data\FileSummaryInfo;
use rollun\Callables\TaskExample\Result\Data\FileSummaryType;

/**
 * Class FileSummary
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class FileSummary implements TaskInterface
{
    const DIR_PATH = 'data/file-summary';

    /**
     * @inheritDoc
     */
    public function getTaskInfoById(string $taskId): TaskInfoInterface
    {
    }

    /**
     * @inheritDoc
     */
    public function getTaskResultById(string $taskId): ResultInterface
    {
    }

    /**
     * @inheritDoc
     *
     * @param CreateTaskParameters $taskParam
     */
    public function runTask(object $taskParam): ResultInterface
    {
        // prepare n
        $n = $taskParam->getN();

        if (file_exists($this->getFilePath($n))) {
            $data = $this->getFileData($n);
            if (empty($data['summary'])) {
                $result = new Result(null, new Status());
                $result->getStatus()->toReject();
                $result->addMessage(new Message('Error', 'Such task already exists'));

                return $result;
            }
        }

        $data = $this->getBaseData();

        // set numbers
        $i = 1;
        while ($i <= $n) {
            $data['numbers'][] = $i;
            $this->saveFile($i, $data);
            $i++;
        }

        // calc summary
        $data['summary'] = array_sum($data['numbers']);
        $this->saveFile($n, $data);

        return new Result(new FileSummaryInfo((string)$n, new FileSummaryType(), 'done'), new Status(Status::STATE_FULFILLED));
    }

    /**
     * @inheritDoc
     */
    public function deleteById(string $id): ResultInterface
    {
    }

    /**
     * @param int $id
     *
     * @return string
     */
    protected function getFilePath(int $id): string
    {
        // create dir if not exists
        if (!file_exists(self::DIR_PATH)) {
            mkdir(self::DIR_PATH, 0777, true);
            sleep(1);
        }

        return self::DIR_PATH . '/' . $id . '.json';
    }

    /**
     * @param int $id
     *
     * @return array
     */
    protected function getFileData(int $id): array
    {
        $filePath = $this->getFilePath($id);

        return !file_exists($filePath) ? $this->getBaseData() : \json_decode(file_get_contents($filePath), true);
    }

    /**
     * @return array
     */
    protected function getBaseData(): array
    {
        return [
            'numbers' => [],
            'summary' => null
        ];
    }

    /**
     * @param int   $id
     * @param array $data
     */
    protected function saveFile(int $id, array $data): void
    {
        file_put_contents($this->getFilePath($id), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        sleep(1);
    }
}
