<?php declare(strict_types=1);

namespace TomPHP\Siren;

// Just like a normal entity, but an embedded sub-entity will have rels, too
final class SubEntity extends Entity implements SubEntityRepresentation
{
    use HasRels;

    public static function fromArray(array $array) : EntityRepresentation
    {
        Entity::parseNestedObjects($array);

        return new self(
            $array['rel'],
            $array['class'] ?? [],
            $array['properties'] ?? [],
            $array['links'] ?? [],
            $array['title'] ?? null,
            $array['actions'] ?? [],
            $array['entities'] ?? []
        );
    }

    public function toArray() : array
    {
        $result        = parent::toArray();
        $result['rel'] = $this->rels;
        return $result;
    }

    /**
     * @param string[]                  $classes
     * @param array                     $properties
     * @param Link[]                    $links
     * @param string                    $title
     * @param Action[]                  $actions
     * @param SubEntityRepresentation[] $entities
     * @param string[]                  $rels
     *
     * @internal
     */
    public function __construct(
        array $rels,
        array $classes,
        array $properties,
        array $links,
        string $title = null,
        array $actions = [],
        array $entities = []
    ) {
        parent::__construct($classes, $properties, $links, $title, $actions, $entities);
        $this->rels = $rels;
    }
}
