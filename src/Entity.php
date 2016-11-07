<?php declare(strict_types=1);

namespace TomPHP\Siren;

final class Entity
{
    /**
     * @var string[]
     */
    private $classes;

    /**
     * @var array
     */
    private $properties;

    public static function builder() : EntityBuilder
    {
        return new EntityBuilder();
    }

    /**
     * @param string[] $classes
     */
    public function __construct(
        array $classes,
        array $properties
    ) {
        $this->classes = $classes;
        $this->properties = $properties;
    }

    public function toArray() : array
    {
        return [
            'class'      => $this->classes,
            'properties' => $this->properties,
        ];
    }

    public function __toString() : string
    {
        return '';
    }
}
