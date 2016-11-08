<?php declare(strict_types=1);

namespace TomPHP\Siren;

final class EntityBuilder
{
    /**
     * @var string[]
     */
    private $classes = [];

    /**
     * @var array
     */
    private $properties = [];

    /**
     * @return $this
     */
    public function addClass(string $name)
    {
        $this->classes[] = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function addProperties(array $properties)
    {
        $this->properties = array_merge(
            $this->properties,
            $properties
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function addProperty(string $name, $value)
    {
        $this->properties[$name] = $value;

        return $this;
    }

    public function build() : Entity
    {
        return new Entity($this->classes, $this->properties);
    }
}
