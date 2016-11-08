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
        $this->classes = array_unique($classes);
        $this->properties = $properties;
    }

    /**
     * @return string[]
     */
    public function getClasses() : array
    {
        return $this->classes;
    }

    public function hasClass(string $name) : bool
    {
        return in_array($name, $this->classes);
    }

    public function getProperties() : array
    {
        return $this->properties;
    }

    public function hasProperty(string $name) : bool
    {
        return isset($this->properties[$name]);
    }

    public function toArray() : array
    {
        $result = [];

        $result['class'] = $this->classes;

        if (count($this->properties)) {
            $result['properties'] = $this->properties;
        }

        return $result;
    }

    public function __toString() : string
    {
        return '';
    }
}
