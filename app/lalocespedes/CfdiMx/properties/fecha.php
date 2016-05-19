<?php

namespace lalocespedes\CfdiMx\properties;

use Exception;
use SimpleXMLElement;

/**
 *
 */
class fecha
{
    final public static function extract(SimpleXMLElement $xml, array $namespace, $version)
    {
        if (empty($xml['fecha'])) throw new Exception('Error. Falta atributo fecha');

        switch ($version) {
            case 3:
            case 3.2:
                return $xml['fecha'];
                break;
            default:
                throw new Exception('Unkown document version ' . $version);
                break;
        }
    }
}
