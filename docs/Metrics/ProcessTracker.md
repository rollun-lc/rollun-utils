# Отслеживание упавших процессов

## Описание
Иногда процессы падают без логов, например, при перерасходе памяти процесс просто убивается OS. Чтобы осталась какая-то информация о таких случаях, было сделано следующее:
1. при старте приложения создается файл с информацией о процессе,
2. при успешном завершении он удаляется,
3. если процесс упал, не дойдя до нормального завершения, то файл соответственно остается, и из него можно получить информацию об упавшем процессе,
4. количество оставшихся файлов пишется в метрику, которую можно посмотреть в Графане,
5. устаревшие файлы подчищаются кроном.

## Реализация

Был сделан класс `ProcessTracker`, который занимается созданием и удалением файлов и может отдавать метрики. Он реализует интерфейс `ProcessTrackerInterface`, который не привязан к файлам и который можно будет реализовать на чем-то другом (например бд).

## Подключение

Чтобы подключить этот функционал в сервисе нужно:
1. [Добавить создание и удаление файла](#создание-и-удаление-файла) в `index.php` (или др.),
2. [Добавить сбор метрики](#настройка-сбора-метрики),
3. [Добавить крон для удаления старых файлов](#крон-для-удаления-старых-файлов).

### Создание и удаление файла
[Пример готового index.php](#пример-indexphp)

В `index.php` (или другом корневом скрипте) нужно выполнить такие действия:
1. В самом начале явно добавить создание `LifeCycleToken`:
    ```
    $lifeCycleToken = LifeCycleToken::createFromHeaders();
    
    // или для консоли:
    $lifeCycleToken = LifeCycleToken::createFromArgv();
    ```
2. Вызвать сохранение данных о процессе, передав туда `lifeCycleToken` и `parentLifeCycleToken`:
   ```
   ProcessTracker::storeProcessData($lifeCycleToken->toString(), $lifeCycleToken->getParentToken());
   ```
3. Добавить `$lifeCycleToken` в контейнер:
   ```
   $container->setService(LifeCycleToken::class, $lifeCycleToken);
   ```
4. В самом конце `index.php` вызывать удаление данных о процессе:
   ```
   ProcessTracker::clearProcessData();
   ```

### Настройка сбора метрики

1. Нужно добавить `ProcessTracker` в список провайдеров метрик в конфиге `MetricsMiddleware`:

```
use rollun\utils\Metrics\Factory\MetricsMiddlewareFactory;
use rollun\utils\Metrics\MetricsMiddleware;
use rollun\utils\Metrics\ProcessTracker;

   MetricsMiddlewareFactory::KEY => [
        MetricsMiddleware::class => [
            MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
                ProcessTracker::class,
            ],
        ],
    ],
```

2. Нужно добавить роут в `routes.php` для `MetricsMiddleware` (+ добавить его в Прометеусе):

```
   $app->get(
        '/metrics',
        MetricsMiddleware::class,
        'metrics'
    );
```

В данном случае имя сервиса - `MetricsMiddleware::class`, но оно может быть любым (как будет указано в конфиге).

### Крон для удаления старых файлов

Реализован колбек `ClearOldProcessFilesCallback`, его нужно только подключить в крон.

```
use rollun\utils\Metrics\Callback\ClearOldProcessFilesCallback;

return [
    SerializedCallbackAbstractFactory::class => [
        'clearOldProcessFiles' => ClearOldProcessFilesCallback::class,
    ],
    CallbackAbstractFactoryAbstract::KEY => [
        'min_multiplexer' => [
            MultiplexerAbstractFactory::KEY_CLASS => Multiplexer::class,
            MultiplexerAbstractFactory::KEY_CALLBACKS_SERVICES => [
               'clearOldProcessFilesCron',
            ],
        ],
        'clearOldProcessFilesCron' => [
            CronExpressionAbstractFactory::KEY_CLASS => CronExpression::class,
            CronExpressionAbstractFactory::KEY_EXPRESSION => "0 1 * * *",
            CronExpressionAbstractFactory::KEY_CALLBACK_SERVICE => 'clearOldProcessFiles',
        ],
    ],
    InterruptAbstractFactoryAbstract::KEY => [
        'cron' => [
            ProcessAbstractFactory::KEY_CLASS => Process::class,
            ProcessAbstractFactory::KEY_CALLBACK_SERVICE => 'min_multiplexer',
        ],
    ],
];
```

## Пример index.php
```
<?php

use rollun\logger\LifeCycleToken;
use rollun\utils\Metrics\ProcessTracker;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
use Zend\ServiceManager\ServiceManager;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$lifeCycleToken = LifeCycleToken::createFromHeaders();
ProcessTracker::storeProcessData($lifeCycleToken->toString(), $lifeCycleToken->getParentToken());

/** @var ServiceManager $container */
$container = require 'config/container.php';

$container->setService(LifeCycleToken::class, $lifeCycleToken);

/** @var Application $app */
$app = $container->get(Application::class);
$factory = $container->get(MiddlewareFactory::class);

// Execute programmatic/declarative middleware pipeline and routing
// configuration statements
(require 'config/pipeline.php')($app, $factory, $container);
(require 'config/routes.php')($app, $factory, $container);

$app->run();

ProcessTracker::clearProcessData();
```

## Структура файла
Название файла - текущий `LifeCycleToken`.

В сам файл записываются такие данные (если они есть):
* `timestamp`
* `parent_lifecycle_token`
* `$_SERVER['REMOTE_ADDR']`
* `$_SERVER['REQUEST_URI']`