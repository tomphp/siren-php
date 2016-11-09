<?php declare(strict_types=1);

namespace TomPHP\Siren;

use Assert\Assertion;
use TomPHP\Siren\Exception\NotFound;

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

    /**
     * @var Link[]
     */
    private $links;

    /**
     * @var string
     */
    private $title;

    /**
     * @var Action[]
     */
    private $actions;

    public static function builder() : EntityBuilder
    {
        return new EntityBuilder();
    }

    /**
     * @param string[] $classes
     * @param array    $properties
     * @param Link[]   $links
     * @param string   $title
     * @param Action[] $actions
     *
     * @internal
     */
    public function __construct(
        array $classes,
        array $properties,
        array $links,
        string $title = null,
        array $actions = []
    ) {
        Assertion::allString($classes);
        Assertion::allIsInstanceOf($links, Link::class);
        Assertion::allIsInstanceOf($actions, Action::class);

        $this->classes = array_unique($classes);
        $this->properties = $properties;
        $this->links = $links;
        $this->title = $title;
        $this->actions = $actions;
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
        return array_key_exists($name, $this->properties);
    }

    /**
     * @throws NotFound
     */
    public function getProperty(string $name)
    {
        if (!$this->hasProperty($name)) {
            throw NotFound::forProperty($name);
        }

        return $this->properties[$name];
    }

    public function getPropertyOr(string $name, $default)
    {
        if (!$this->hasProperty($name)) {
            return $default;
        }

        return $this->properties[$name];
    }

    public function hasLink(string $rel) : bool
    {
        $rels = array_reduce(
            $this->links,
            function (array $result, Link $link) {
                return array_merge($result, $link->getRels());
            },
            []
        );

        return in_array($rel, $rels);
    }

    /**
     * @return Link[]
     */
    public function getLinks() : array
    {
        return $this->links;
    }

    public function getLink(string $rel) : Link
    {
        foreach ($this->links as $link) {
            if (in_array($rel, $link->getRels())) {
                return $link;
            }
        }

        throw NotFound::forLink($rel);
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @return Action[]
     */
    public function getActions() : array
    {
        return $this->actions;
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

    public function toJson() : string
    {
        return json_encode($this->toArray());
    }
}
