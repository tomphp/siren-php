<?php declare(strict_types=1);

namespace TomPHP\Siren;

use Assert\Assertion;

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
     * @var Link[]
     */
    private $links = [];

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

    /**
     * @param Link|string $linkOrRel
     * @param string      $href
     *
     * @return $this
     */
    public function addLink($linkOrRel, string $href = null)
    {
        Assertion::string($linkOrRel);

        $this->links[] = new Link($linkOrRel, $href);

        return $this;
    }

    public function build() : Entity
    {
        return new Entity(
            $this->classes,
            $this->properties,
            $this->links
        );
    }
}
