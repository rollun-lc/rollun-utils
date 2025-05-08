<?php

/**
 * Zaboy lib (http://zaboy.org/lib/)
 *
 * @copyright  Zaboychenko Andrey
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace rollun\utils\Json\Plugin;

use mindplay\jsonfreeze\JsonSerializer;
use rollun\utils\Json\Exception as JsonException;
use rollun\utils\Json\Serializer;

/**
 *
 *
 * @category   utils
 * @package    zaboy
 */
class ExceptionSerializer
{
    public static function exceptionSerialize(\Exception $exception)
    {
        $data = [
            JsonSerializer::TYPE => $exception::class,
            /*"message" => $exception->getMessage(),*/
            /*"code" => $exception->getCode(),*/
            "line" => $exception->getLine(),
            "file" => $exception->getFile(),
            "prev" => $exception->getPrevious(),
        ];
        $refClassExc = new \ReflectionClass($exception);
        /** @var \ReflectionProperty $property */
        foreach ($refClassExc->getProperties() as $property) {
            if (!in_array($property->getName(), array_keys($data))) {
                $property->setAccessible(true);
                $data[$property->getName()] = Serializer::jsonSerialize($property->getValue($exception));
                $property->setAccessible(false);
            }
        }
        return $data;
    }

    public static function exceptionUnserialize($data)
    {

        $prev = isset($data["prev"]) ? static::exceptionUnserialize($data["prev"]) : null;

        try {
            $exc = new $data[JsonSerializer::TYPE]($data["message"], $data["code"], $prev);
        } catch (\Exception $exc) {
            $exc = new \RuntimeException(
                'Can not Unserialize Exception '
                . $data[JsonSerializer::TYPE],
                0,
                $exc
            );
        }

        $data['trace'] = [];
        $propArray = ['line', 'file', 'trace'];
        $refClassExc = new \ReflectionClass(\Exception::class);
        foreach ($propArray as $propName) {
            $refProperty = $refClassExc->getProperty($propName);
            $refProperty->setAccessible(true);
            $refProperty->setValue($exc, $data[$refProperty->getName()]);
            $refProperty->setAccessible(false);
        }
        $refClassExc = new \ReflectionClass($data['#type']);
        foreach ($refClassExc->getProperties() as $refProperty) {
            if (!in_array($refProperty->getName(), $propArray) &&
                in_array($refProperty->getName(), array_keys($data))
            ) {
                $refProperty->setAccessible(true);
                $refProperty->setValue($exc, Serializer::jsonUnserialize($data[$refProperty->getName()]));
                $refProperty->setAccessible(false);
            }
        }
        return $exc;
    }

    public static function defineExceptionSerializer($value, $serializer)
    {
        $objectClasses = static::getClassesFromObject($value)['class'];
        self::define($objectClasses, $serializer);
    }

    protected static function getClassesFromObject($subject, $typesAndObjects = ['class' => [], 'objects' => []])
    {
        if (is_scalar($subject) || is_resource($subject) || empty($subject) || $subject instanceof \Closure) {
            return $typesAndObjects;
        }

        if (is_array($subject)) {
            foreach ($subject as $value) {
                $typesAndObjects = static::getClassesFromObject($value, $typesAndObjects); //Recursion
            }
            return $typesAndObjects;
        }

        if (is_object($subject)) {
            //We are looking circular references
            foreach ($typesAndObjects['objects'] as $value) {
                if ($value === $subject) {
                    return $typesAndObjects;
                }
            }
            $typesAndObjects['objects'][] = $subject;
            //We collect unique class names
            if (!in_array($subject::class, $typesAndObjects['class'])) {
                $typesAndObjects['class'][] = $subject::class;
            }
            $propsArray = static::getClassProperties($subject);
            //Recursion
            return static::getClassesFromObject($propsArray, $typesAndObjects);
        }

        throw new JsonException('Unknown type');
    }

    /**
     * Recursive function to get an associative array of class properties by property name => value
     * including inherited from extended classes
     *
     * @param object $object
     * @param string $className
     * @return array [$propName1 =>$propVal1, $propName2=> ...]
     */
    protected static function getClassProperties($object, $className = null)
    {
        $className = $className ?: $object::class;
        $ref = new \ReflectionClass($className);
        $props = $ref->getProperties();
        $props_arr = [];
        foreach ($props as $prop) {
            $propName = $prop->getName();

            if ($prop->isPublic()) {
                $props_arr[$propName] = $prop->getValue($object);
            }
            if ($prop->isPrivate() || $prop->isProtected()) {
                $prop->setAccessible(true);
                $props_arr[$propName] = $prop->getValue($object);
                $prop->setAccessible(false);
            }
            continue;
        }
        $parentClass = $ref->getParentClass();
        if ($parentClass) {
            $parent_props_arr = self::getClassProperties($object, $parentClass->getName()); //RECURSION
            if (count($parent_props_arr) > 0) {
                $props_arr = array_merge($parent_props_arr, $props_arr);
            }
        }
        return $props_arr;
    }

    protected static function define($objectClasses, $serializer)
    {
        foreach ($objectClasses as $className) {

            if (is_a($className, 'Exception', true)) {
                $serializer->defineSerialization(
                    $className,
                    [self::class, 'exceptionSerialize'],
                    [self::class, 'exceptionUnserialize']
                );
            }
        }
    }

    public static function defineExceptionUnserializer($serializedValue, $serializer)
    {
        $objectClasses = static::getClassesFromString($serializedValue);
        self::define($objectClasses, $serializer);
    }

    /**
     * Extract types of serialized objects
     *
     * in:
     * <code>
     * '[1,{ "#type": "Exception", "message": "Exception",  "string": "",  "code": 404,  "previous":
     * {"#type": "zaboy\\utils\\Json\\Exception", "message": "JsonException"}},"a",{"#type": "stdClass"}]'
     * </code>
     *
     * out:
     * <code>
     * out:['Exception', 'zaboy\utils\Json\Exception', 'stdClass']
     * </code>
     *
     *
     * @param string $subject
     * @return array
     */
    protected static function getClassesFromString($subject)
    {
        $pattern = '/"#type": "([\w\x5c]+)"/';
        $match = [];
        $types = [];

        if (preg_match_all($pattern, $subject, $match)) {
            if (count($match) > 1) {
                foreach ($match[1] as $type) {
                    $types[] = preg_replace('|([\x5c]+)|s', '\\', $type);
                }
            }
        }

        return $types;
    }

}
