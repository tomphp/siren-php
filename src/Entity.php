<?php declare(strict_types=1);

namespace TomPHP\Siren;

use Assert\Assertion;
use Psr\Link\LinkProviderInterface;
use TomPHP\Siren\Exception\NotFound;

class Entity implements LinkProviderInterface, EntityRepresentation
{
    use SirenObject;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @var Link[]
     */
    protected $links;

    /**
     * @var Action[]
     */
    protected $actions;

    /**
     * @var SubEntityRepresentation[]
     */
    protected $entities;

    public static function builder() : EntityBuilder
    {
        return new EntityBuilder();
    }

    protected static function parseNestedObjects(array &$array)
    {
        if (isset($array['links'])) {
            $array['links'] = array_map([Link::class, 'fromArray'], $array['links']);
        }

        if (isset($array['actions'])) {
            $array['actions'] = array_map([Action::class, 'fromArray'], $array['actions']);
        }

        if (isset($array['entities'])) {
            $array['entities'] = array_map(
                function (array $entity) {
                    if (array_key_exists('href', $entity)) {
                        return EntityLink::fromArray($entity);
                    }
                    return SubEntity::fromArray($entity);
                },
                $array['entities']
            );
        }

    }

    /**
     * @return self
     */
    public static function fromArray(array $array) : EntityRepresentation
    {
        self::parseNestedObjects($array);
        return new self(
            $array['class'] ?? [],
            $array['properties'] ?? [],
            $array['links'] ?? [],
            $array['title'] ?? null,
            $array['actions'] ?? [],
            $array['entities'] ?? []
        );
    }

    /**
     * @param string[]    $classes
     * @param array       $properties
     * @param Link[]      $links
     * @param string      $title
     * @param Action[]    $actions
     * @param SubEntity[] $entities
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
        Assertion::allIsInstanceOf($entities, SubEntityRepresentation::class);

        $this->classes    = array_unique($classes);
        $this->properties = $properties;
        $this->links      = $links;
        $this->title      = $title;
        $this->actions    = $actions;
        $this->entities   = $entities;
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

        return in_array($rel, $rels, true);
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
                    return $link->hasRel($rel);
                }
            )
        );
    }

    public function getLinksByClass(string $class)
    {
        return array_values(
            array_filter(
                $this->links,
                function (Link $link) use ($class) {
                    return $link->hasClass($class);
                }
            )
        );
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
     * @return SubEntityRepresentation[]
     */
    public function getEntities() : array
    {
        return $this->entities;
    }

    /**
     * @SubEntityRepresentation[]
     */
    public function getEntitiesByProperty(string $name, $value) : array
    {
        return array_values(array_filter(
            $this->entities,
            function (SubEntityRepresentation $entity) use ($name, $value) {
                try {
                    return $entity->getProperty($name) === $value;
                } catch (NotFound $e) {
                    return false;
                }
            }
        ));
    }

    /**
     * @SubEntityRepresentation[]
     */
    public function getEntitiesByClass(string $name) : array
    {
        return array_values(array_filter(
            $this->entities,
            function ($entity) use ($name) {
                return $entity->hasClass($name);
            }
        ));
    }

    /**
     * @SubEntityRepresentation[]
     */
    public function getEntitiesByRel(string $rel) : array
    {
        return array_values(array_filter(
            $this->entities,
            function ($entity) use ($rel) {
                return $entity->hasRel($rel);
            }
        ));
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
