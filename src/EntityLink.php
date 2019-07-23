<?php declare(strict_types=1);

namespace TomPHP\Siren;

use Assert\Assertion;

final class EntityLink implements EntityRepresentation, SubEntityRepresentation
{
    use SirenObject;
    use HasRels;

    /**
     * @var string
     */
    private $href;

    /**
     * @var string
     */
    private $type;

    /**
     * @return self
     */
    public static function fromArray(array $array) : EntityRepresentation
    {
        return new self(
            $array['rel'],
            $array['href'],
            $array['class'] ?? [],
            $array['title'] ?? null,
            $array['type'] ?? null
        );
    }

    /**
     * @param string[] $rels
     * @param string   $href
     * @param string[] $class
     * @param string   $title
     * @param string   $type
     */
    public function __construct(array $rels, string $href, array $classes = [], string $title = null, string $type = null)
    {
        Assertion::allString($rels);
        Assertion::allString($classes);

        $this->rels    = $rels;
        $this->href    = $href;
        $this->classes = $classes;
        $this->title   = $title;
        $this->type    = $type;
    }

    public function toArray() : array
    {
        $result = [
            'rel'  => $this->rels,
            'href' => $this->href,
        ];

        if (count($this->classes)) {
            $result['class'] = $this->classes;
        }

        if (!is_null($this->title)) {
            $result['title'] = $this->title;
        }

        if (!is_null($this->type)) {
            $result['type'] = $this->type;
        }

        return $result;
    }
}
