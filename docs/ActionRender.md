#ActionRender

## Последовательость работы MinePipe

В самом простом случае у нас существует один **Middleware** реализущий интерфейс `ActionRenderInterface`
Который по своей сути должен выполнять дейсвие и возвращать ответ пользователю.

Так же данный **Middleware** может быть представлен в виде двух **Middleware**

1) **Action** - Выполняет определенное действие. Результат должен пометсить в атребут запроста `Response-Data`

2) **Render** - Отдает ответ пользователю.

Каждый из эих двух **Middleware** могут быть заменены на двумя **Middleware**

* Для **Action**

    1) **ParamResolver** - выкусывает нужные параметры акшену из запроса и кладет их в атрибуты.
    
    2) **Action** -  выполняет действие и результат кладет в `Responce-Data`.
 
* Соответсвенно для **Render**
 
    1) **ParamResolver** - выкусывает нужные параметры вьюверу из запроса и кладет их в атрибуты.
    
    2) **Render** -  выполняет отрисовку результата и возвращает пользователю

## Замечания

* Каждый из **Middleware** может быть **Middleware**, **pipeLine** либо **LazyLoadFactory** (Которая вернет **Middleware**).

* **LazyLoadFactory** не могут передавать какие то занчения в **Middleware** по средсву **Request**.
Для этого стоит использовать либо параметры контейнера либо **ParamResolver Middleware**.

## Компоненты

###ActionRenderFactory

Фабрика для создания **ActionRender**. 
Может быть как последовательность двух **Middleware** так и одним **Middleware** который реализует интерфейс `ActionRenderInterface`.
Значение задаеться в конфиге

Пример для ActionRender Class:
```php
     ActionRenderFactory::KEY_ACTION_RENDER => [
        'home' => [
            ActionRenderFactory::KEY_AR_MIDDLEWARE => 'ActionRenderHome'
        ]
     ]
```
Где `'ActionRenderHome'` имя сервиса по которому **SM** вернет класс реализующий `ActionRenderInterface`.

Либо для 2 Middleware 
```php
     ActionRenderFactory::KEY_ACTION_RENDER => [
        'home' => [
            ActionRenderFactory::KEY_AR_MIDDLEWARE => [
                ActionRenderFactory::KEY_ACTION => 'Action',
                ActionRenderFactory::KEY_RENDER => 'Render'
            ]
        ]
     ]
```

Где `'Action'` и `'Render'` имена сервисов по которым **SM** вернет класс реализующий **MiddlewareInterface**. 
Где `'Action'` выполнит какое то дейсвие и результат положит в атребут запроса `Responce-Data`, а `'Render'` отобразит данный результат.

###ResponseRendererFactory

**LazyLoad** фабрика которая относительно ожидаемого типа ответа(Accept in request Header), 
 достанет по имени сервиса **Middleware** из **SM** и передаст ему управление.
 
 Настраивается с помощью конфига 
 Пример:
```php
 ResponseRendererFactory::KEY_RESPONSE_RENDERER => [
    'simpleHtmlJsonRenderer' => [
        ResponseRendererFactory::KEY_ACCEPT_TYPE_PATTERN => [
            //pattern => middleware
            '/application\/json/' => \rollun\utils\ActionRender\Renderer\Json\JsonRendererAction::class,
            '/text\/html/' => 'htmlReturner'
        ]
    ] 
 ],
```

Ключ массива `ResponseRendererFactory::KEY_RESPONSE_RENDERER` указыват на имя сервиса по которому 
сможем получить **lazyLoad** звгрузку терубемых конфигураций.

А в самой конфигурации в массиве `ResponseRendererFactory::KEY_ACCEPT_TYPE_PATTERN` мы ключем указываем паттерн определения **accept**, 
а занчением имя сервиса по которому из **SM** сможем получить **Middleware**.
> В данном случае конфигурация называется `'simpleHtmlJsonRenderer'`

### AbstractMiddlewarePipeFactoryAbstract

Фабрика для создания любых **MiddlewarePipe**.

**PipeLine** задаются в конфиге.

Пример:
```php
    AbstractMiddlewarePipeFactoryAbstract::KEY_AMP => [
        'htmlReturner' => [
            'middlewares' => [
                'HtmlParamResolver'
                'HtmlRendererAction'
            ]
        ]
    ],
```

Где `'htmlReturner'` имя сервиса по которому будет возвращен **Pipe**.   
А `'middlewares'` массив содержащий список имен сервисов по которым можено будет из **SM** достать **Middleware**.
