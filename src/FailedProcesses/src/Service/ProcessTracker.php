<?php

namespace rollun\utils\FailedProcesses\Service;

use OpenMetricsPhp\Exposition\Text\Collections\GaugeCollection;
use OpenMetricsPhp\Exposition\Text\Metrics\Gauge;
use OpenMetricsPhp\Exposition\Text\Types\Label;
use OpenMetricsPhp\Exposition\Text\Types\MetricName;
use rollun\utils\Metrics\MetricsProviderInterface;

class ProcessTracker implements MetricsProviderInterface
{
    private const PROCESS_TRACKING_DIR = 'data/process-tracking/';

    /** @var string */
    private static $filePath;

    /**
     * TODO: make $lifeCycleToken optional
     */
    public static function storeProcessData(string $lifeCycleToken, string $parentLifeCycleToken = null)
    {
        $dirPath = static::getProcessTrackingDir();

        $dirPath .= (new \DateTime())->format('Y-m-d') . '/';

        if (!file_exists($dirPath)) {
            $isDirCreated = mkdir($dirPath, 0777, true);
            if (!$isDirCreated) {
                return;
            }
        }

        static::$filePath = $dirPath . $lifeCycleToken;

        $requestInfo = 'started_at: ' . (new \DateTime())->format(DATE_RFC3339) . PHP_EOL;

        if (!empty($parentLifeCycleToken)) {
            $requestInfo .= 'parent_lifecycle_token: ' . $parentLifeCycleToken . PHP_EOL;
        }

        if (!empty($_SERVER['REMOTE_ADDR'])) {
            $requestInfo .= 'REMOTE_ADDR: ' . $_SERVER['REMOTE_ADDR'] . PHP_EOL;
        }

        if (!empty($_SERVER['REQUEST_URI'])) {
            $requestInfo .= 'REQUEST_URI: ' . $_SERVER['REQUEST_URI'] . PHP_EOL;
        }

        file_put_contents(static::$filePath, $requestInfo);
    }

    public static function clearProcessData()
    {
        if (!is_string(static::$filePath)) {
            return;
        }
        unlink(static::$filePath);
    }

    public static function clearOldProcessesData()
    {
        $dirPath = static::getProcessTrackingDir();

        $dirsByDate = glob($dirPath . '*', GLOB_ONLYDIR);

        if (empty($dirsByDate)) {
            return;
        }

        $monthAgo = (new \DateTime())->sub(new \DateInterval('P30D'))->format('Y-m-d');

        // получаем все папки старше 1 месяца
        $dirsToRemove = array_filter($dirsByDate, function ($dateDirPath) use ($monthAgo) {
            $dirName = explode('/', $dateDirPath);
            if (empty($dirName)) {
                return false;
            }
            $dirName = end($dirName);
            // название папки должно быть формата 'Y-m-d', иначе пропускаем
            if (!\DateTime::createFromFormat('Y-m-d', $dirName) instanceof \DateTime) {
                return false;
            }
            return $dirName < $monthAgo;
        });

        foreach ($dirsToRemove as $dateDirPath) {
            exec("rm -rf " . $dateDirPath);
        }
    }

    /**
     * @throws \Exception
     */
    public function getMetrics(): array
    {
        return [
            GaugeCollection::fromGauges(
                MetricName::fromString('failed_processes'),
                Gauge::fromValue(static::getFailedProcessesCount(5))->withLabels(
                    Label::fromNameAndValue('older_than', '5_min')
                ),
                Gauge::fromValue(static::getFailedProcessesCount(60))->withLabels(
                    Label::fromNameAndValue('older_than', '1_hour')
                ),
                Gauge::fromValue(static::getFailedProcessesCount(60 * 12))->withLabels(
                    Label::fromNameAndValue('older_than', '12_hour')
                ),
                Gauge::fromValue(static::getFailedProcessesCount(0))->withLabels(
                    Label::fromNameAndValue('older_than', 'now')
                )
            )
        ];
    }

    public static function getAllData(): array
    {
        $data = [];

        $dirPath = static::getProcessTrackingDir();

        $filePaths = [];

        exec("find $dirPath -type f", $filePaths);

        foreach ($filePaths as $filePath) {
            $filePathParts = explode('/', $filePath);
            if (empty($filePathParts)) {
                continue;
            }
            $lifeCycleToken = $filePathParts[count($filePathParts) - 1];
            $fileData = file_get_contents($filePath);
            $parsedData = self::parseFileData($fileData);
            $parsedData = array_merge($parsedData, [
                'service_name' => self::getServiceName(),
                'life_cycle_token' => $lifeCycleToken,
            ]);
            $data[] = $parsedData;
        }

        return $data;
    }

    private static function parseFileData(string $fileData): array
    {
        $lines = explode("\n", $fileData);

        if (empty($lines)) {
            return [];
        }

        $parsedData = [];

        foreach ($lines as $line) {
            $lineParts = explode(':', $line, 2);

            if (empty($lineParts) || count($lineParts) < 2) {
                continue;
            }

            $parsedData[$lineParts[0]] = trim($lineParts[1]);
        }

        if (!isset($parsedData['started_at']) && isset($parsedData['timestamp'])) {
            $date = new \DateTime();
            $date->setTimestamp($parsedData['timestamp']);
            $parsedData['started_at'] = $date->format(DATE_RFC3339);
        }

        return [
            'started_at' => $parsedData['started_at'] ?? null,
            'parent_lifecycle_token' => $parsedData['parent_lifecycle_token'] ?? null,
            'ip' => $parsedData['REMOTE_ADDR'] ?? null,
            'uri' => $parsedData['REQUEST_URI'] ?? null,
        ];
    }

    private static function getFailedProcessesCount(int $passedMinutes): int
    {
        $dirPath = static::getProcessTrackingDir();

        $filesCount = exec("find $dirPath -type f -mmin +$passedMinutes | wc -l");

        if ($filesCount === false) {
            throw new \RuntimeException("Can't get files count for dir '$dirPath'");
        }

        if (!is_numeric($filesCount)) {
            throw new \RuntimeException("Files count must be numeric");
        }

        return (int)$filesCount;
    }

    private static function getServiceName(): string
    {
        $serviceName = exec('hostname');

        if ($serviceName === false) {
            throw new \RuntimeException("Can't get service name");
        }

        $serviceNameParts = explode('.', $serviceName);

        if (empty($serviceNameParts)) {
            throw new \RuntimeException("Can't get service name");
        }

        return $serviceNameParts[0];
    }

    private static function getProcessTrackingDir(): string
    {
        return self::PROCESS_TRACKING_DIR;
    }
}