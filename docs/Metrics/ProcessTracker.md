# Отслеживание упавших процессов

## Описание
Иногда процессы падают без логов, например, при перерасходе памяти процесс просто убивается OS. Чтобы осталась какая-то информация о таких случаях, было сделано следующее:
1. при старте приложения создается файл с информацией о процессе,
2. при успешном завершении он удаляется,
3. если процесс упал, не дойдя до нормального завершения, то файл соответственно остается, и из него можно получить информацию об упавшем процессе.

Дополнительные функции:
* можно подчищать устаревшие файлы по крону,
* можно писать количество оставшихся файлов в метрику (Infrastructure metrics / Failed processes),
* можно добавить вывод информации из файлов в датастор на rollun-net: https://rollun.net/FailedProcesses


### Перед подключением

В этом релизе были добавлены новые конфиг-провайдеры (`"rollun\\utils\\FailedProcesses\\ConfigProvider", "rollun\\utils\\Metrics\\ConfigProvider"`), и чтобы они подтянулись в файл `config.php` желательно переустановить пакет `rollun-utils`. Или же можно добавить их вручную.

## Подключение

Чтобы подключить этот функционал в сервисе нужно:

1. [Добавить параметр env](#параметр-env)
2. [Добавить создание и удаление файла](#создание-и-удаление-файла) в `index.php` (или др.),
3. [Добавить крон для удаления старых файлов](#крон-для-удаления-старых-файлов),
4. [Сгенерировать openapi](#просмотр-данных-из-файлов-в-датасторе) для просмотра упавших процессов на rollun-net,
5. [Добавить сбор метрики](#настройка-сбора-метрики).

### Параметр env

```
TRACK_PROCESSES=true
```

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
   use rollun\utils\FailedProcesses\Service\ProcessTracker;
   
   ProcessTracker::storeProcessData(
      $lifeCycleToken->toString(),
      $lifeCycleToken->hasParentToken() ? $lifeCycleToken->getParentToken()->toString() : null
   );
   ```
3. Добавить `$lifeCycleToken` в контейнер:
   ```
   $container->setService(LifeCycleToken::class, $lifeCycleToken);
   ```
4. В самом конце `index.php` вызывать удаление данных о процессе:
   ```
   ProcessTracker::clearProcessData();
   ```
   
### Крон для удаления старых файлов

Реализован колбек `ClearOldProcessFilesCallback`, его нужно только подключить в крон.

```
use rollun\utils\FailedProcesses\Callback\ClearOldProcessFilesCallback;

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

### Просмотр данных из файлов в датасторе

Датастор: https://rollun.net/FailedProcesses

Чтобы выводить информацию в нем, нужно 
1. Cгенерировать серверную часть openapi https://github.com/rollun-com/openapi-manifests/blob/master/failed_processes__v1.yml ,
2. Добавить свой сервис в список серверов этого манифеста и запушить в `openapi-manifests`,
3. Обновить `composer update` в `rollun-net` и выгрузить.

### Настройка сбора метрики

1. Нужно добавить `ProcessTracker` в список провайдеров метрик в конфиге `MetricsMiddleware`:

```
use rollun\utils\Metrics\Factory\MetricsMiddlewareFactory;
use rollun\utils\Metrics\MetricsMiddleware;
use rollun\utils\FailedProcesses\Service\ProcessTracker;

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



## Пример index.php
```
<?php

use rollun\logger\LifeCycleToken;
use rollun\utils\FailedProcesses\Service\ProcessTracker;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
use Zend\ServiceManager\ServiceManager;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$lifeCycleToken = LifeCycleToken::createFromHeaders();
ProcessTracker::storeProcessData(
      $lifeCycleToken->toString(),
      $lifeCycleToken->hasParentToken() ? $lifeCycleToken->getParentToken()->toString() : null
   );

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
* `datetime`
* `parent_lifecycle_token`
* `$_SERVER['REMOTE_ADDR']`
* `$_SERVER['REQUEST_URI']`