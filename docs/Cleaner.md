#UTILS
##Cleaner
    rollun\utils\Cleaner\Cleaner

Объект предназначен удаления сущностей ( объектов, строк, файлов ... ).
[Cleaner.php](https://github.com/rollun-com/rollun-utils/tree/master/src/Cleaner/Cleaner.php).

###КАК ЭТО РАБОТАЕТ
Cleaner получает список с итератором и валидатор как зависимости. Перебирает  сущности итератора, проверяет их валидатором и если валидатор вернул false,
Cleaner удаляет этот элемент из списка путем вызова метода ` public function deleteItem($item);`.

###Что такое валидатор
Объект, реализующий метод `public function isValid($value);` ( интерфейс `CleaningValidatorInterface`).

###Можно ли использовать стандартный валидатор Zend\Validator?
ДА, можно. Его нужно 'обернуть' в `ZendValidatorAdapter`. Пример можно посмотреть в `namespace rollun\utils\Cleaner\Example\DirCleaner;`

        //make Zend file size validator
        $zendFileValidator = new ZendValidatorFileSize($maxSizeInBytes);
        //make CleaningValidatorInterface from ZendValidatorInterface
        $cleaningValidator = new ZendValidatorAdapter($zendFileValidator);
