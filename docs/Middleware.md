## Middleware
Библиотекой поставляется несколько middlewares которые можно подключить.

```php
1. $app->pipe(\rollun\logger\Middleware\MetricMiddleware::class); //  нужно подключать прежде чем RouteMiddleware
```
