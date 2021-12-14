# Отдача метрик в Прометеус по запросу

## Описание

Прометеус запрашивает url метрики, например `/metrics`, и получает значения всех метрик в нужном формате. Для этого реализован контроллер `MetricsMiddleware`, для которого можно задать в конфиге список метрик.

"Список метрик" - это на самом деле список провайдеров метрик, которые реализуют интерфейс `MetricProviderInterface`.

Интерфейс `MetricProviderInterface` требует возвращения метрик в формате библиотеки https://github.com/openmetrics-php/exposition-text.

В примерах ниже имя сервиса - `MetricsMiddleware::class`, но оно может быть любым (как будет задано в конфиге). Поэтому возможно создать несколько роутов для отдачи метрик и сконфигурировать для них разные контроллеры с разными метриками.

### Пример конфига:
```
use rollun\utils\Metrics\Factory\MetricsMiddlewareFactory;
use rollun\utils\Metrics\MetricsMiddleware;
use rollun\utils\Metrics\ProcessTracker;

   MetricsMiddlewareFactory::KEY => [
        MetricsMiddleware::class => [
            MetricsMiddlewareFactory::KEY_METRIC_PROVIDERS => [
                ProcessTracker::class,
                // other providers
            ],
        ],
    ],
```

### Пример роута

```
use rollun\utils\Metrics\MetricsMiddleware;

   $app->get(
        '/metrics',
        MetricsMiddleware::class,
        'metrics'
    );
```
