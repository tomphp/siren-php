<?php declare(strict_types=1);

namespace TomPHP\Siren;

use Assert\Assertion;
use Psr\Link\LinkProviderInterface;
use TomPHP\Siren\Exception\NotFound;

final class Entity implements LinkProviderInterface
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

    /**
     * @var EntityLink[]
     */
    private $entities;

    public static function builder() : EntityBuilder
    {
        return new EntityBuilder();
    }

    public static function fromArray(array $array) : self
    {
        $links = [];
        if (isset($array['links'])) {
            $links = array_map([Link::class, 'fromArray'], $array['links']);
        }

        $actions = [];
        if (isset($array['actions'])) {
            $actions = array_map([Action::class, 'fromArray'], $array['actions']);
        }

        $entities = [];
        if (isset($array['entities'])) {
            $entities = array_map([EntityLink::class, 'fromArray'], $array['entities']);
        }

        return new self(
            $array['class'] ?? [],
            $array['properties'] ?? [],
            $links,
            $array['title'] ?? null,
            $actions,
            $entities
        );
    }

    /**
     * @param string[]     $classes
     * @param array        $properties
     * @param Link[]       $links
     * @param string       $title
     * @param Action[]     $actions
     * @param EntityLink[] $entities
     *
     * @internal
     */
    public function __construct(
        array $classes,
        array $properties,
        array $links,
        string $title = null,
        array $actions = [],
        array $entities = []
    ) {
        Assertion::allString($classes);
        Assertion::allIsInstanceOf($links, Link::class);
        Assertion::allIsInstanceOf($actions, Action::class);
        Assertion::allIsInstanceOf($entities, EntityLink::class);

        $this->classes = array_unique($classes);
        $this->properties = $properties;
        $this->links = $links;
        $this->title = $title;
        $this->actions = $actions;
        $this->entities = $entities;
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

    public function getLinksByRel($rel)
    {
        return array_values(
            array_filter(
                $this->links,
                function (Link $link) use ($rel) {
                    return in_array($rel, $link->getRels());
                }
            )
        );
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

    public function hasAction(string $name) : bool
    {
        foreach ($this->actions as $action) {
            if ($action->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws NotFound
     */
    public function getAction(string $name) : Action
    {
        foreach ($this->actions as $action) {
            if ($action->getName() === $name) {
                return $action;
            }
        }

        throw NotFound::forAction($name);
    }

    /**
     * @return EntityLink[]
     */
    public function getEntities() : array
    {
        return $this->entities;
    }

    public function toArray() : array
    {
        $result = [];

        if (count($this->classes)) {
            $result['class'] = $this->classes;
        }

        if (count($this->properties)) {
            $result['properties'] = $this->properties;
        }

        if (!is_null($this->title)) {
            $result['title'] = $this->title;
        }

        if (count($this->links)) {
            $result['links'] = array_map([$this, 'convertToArray'], $this->links);
        }

        if (count($this->actions)) {
            $result['actions'] = array_map([$this, 'convertToArray'], $this->actions);
        }

        if (count($this->entities)) {
            $result['entities'] = array_map([$this, 'convertToArray'], $this->entities);
        }

        return $result;
    }

    public function toJson() : string
    {
        return json_encode($this->toArray());
    }

    private function convertToArray($object) : array
    {
        return $object->toArray();
    }
}
