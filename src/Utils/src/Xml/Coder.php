<?php

namespace rollun\utils\Xml;

use InvalidArgumentException;
use RuntimeException;
use SimpleXMLElement;

class Coder
{
    /**
     * Converts xml string to array
     * @param string $xmlString
     * @return array
     */
    public function decode(string $xmlString): array
    {
        $xml = simplexml_load_string($xmlString, SimpleXMLElement::class, LIBXML_NOCDATA);
        if ($xml === false) {
            throw new InvalidArgumentException('Failed load xml string.');
        }

        return $this->objectToArray($xml);
    }

    /**
     * Converts SimpleXMLElement to array
     *
     * @param SimpleXMLElement $object
     * @return array
     */
    protected function objectToArray(SimpleXMLElement $object): array
    {
        $json = json_encode($object);
        $array = json_decode($json, true);

        if ($array === false) {
            throw new RuntimeException('Failed converting SimpleXMLElement to array.');
        }

        // Add root element cause json_encode ignores it
        return [
            $object->getName() => $array
        ];
    }
}