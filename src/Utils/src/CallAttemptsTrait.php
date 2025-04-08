<?php


namespace rollun\utils;


/**
 * Trait CallAttemptsTrait
 * @package rollun\utils
 *
 * @todo need tests
 */
trait CallAttemptsTrait
{
    /**
     * Tries to call the callback function a certain number of times with a certain delay.
     *
     * @param int $attempts
     * @param int $interval
     * @param array $itemData
     * @param bool $createIfAbsent
     *
     * @return mixed
     */
    public static function callAttemptsCallable($attempts, $interval, callable $callback, ...$data)
    {
        if ($attempts <= 0) {
            throw new \InvalidArgumentException('Number of attempts must be greater than zero.');
        }

        $counter = 1;
        do {
            try {
                return $callback(...$data);
            } catch (\Throwable $e) {
                if ($counter >= $attempts) {
                    throw $e;
                } else {
                    $counter++;
                    usleep($interval + random_int(100000, 200000));
                }
            }
        } while (true);
    }

    /**
     * Tries to call an object method four times with a delay of half a second.
     *
     * @param $method
     * @param mixed ...$data
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    public function callAttemptsMethod($method, ...$data) {
        if (method_exists($this, $method)) {
            return self::callAttemptsCallable(4, 500000, [$this, $method], ...$data);
        }

        throw new \Exception('method ' . $method . ' not found in ' . static::class . ' class');
    }

    /**
     * Tries to call the callback function four times with a delay of half a second.
     * Does the same as the callAttemptsCallable method, but is called without additional parameters.
     *
     * @param $callable
     * @param mixed ...$data
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    public function callAttempts($callable, ...$data) {
        if (is_callable($callable)) {
            return self::callAttemptsCallable(4, 500000, $callable, ...$data);
        }

        throw new \Exception('First param must be callable');
    }
}