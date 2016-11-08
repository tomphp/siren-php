<?php declare(strict_types=1);

namespace TomPHP\Siren\Exception;

use TomPHP\ExceptionConstructorTools;

final class NotFound extends \RuntimeException implements Exception
{
    use ExceptionConstructorTools;

    const PROPERTY = 1;

    /**
     * @private
     */
    const PROPERTY_MESSAGE = 'Property "%s" was not found.';

    public static function fromProperty(string $name) : self
    {
        return self::create(self::PROPERTY_MESSAGE, [$name], self::PROPERTY);
    }
}
