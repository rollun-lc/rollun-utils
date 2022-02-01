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
     *
     * @throws \Throwable
     * @todo move to utils
     *
     */
    public static function callAttemptsCallable($attempts, $interval, callable $callback, ...$data)
    {
        $counter = 0;

        while ($counter <= $attempts) {
            $counter++;

            try {
                return $callback(...$data);
            } catch (\Throwable $exception) {
                usleep($interval + random_int(100000, 200000));
            }
        }

        throw $exception;
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

        throw new \Exception('method ' . $method . ' not found in ' . get_called_class() . ' class');
    }

    /**
     * Tries to call the callback function four times with a delay of half a second.
     * Does the same as the callAttemptsCallable method, but is called without additional parameters.
     *
     * @param $callable
     * @param mixed ...$data
     *
     * @return array
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