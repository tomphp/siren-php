<?php declare(strict_types=1);

namespace TomPHP\Siren;

use Psr\Link\LinkInterface;

final class Link implements LinkInterface
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

    public static function fromArray(array $array)
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
     * @param string[] $classes
     * @param string   $title
     * @param string   $type
     */
    public function __construct(
        array $rels,
        string $href,
        array $classes = [],
        string $title = null,
        string $type = null
    ) {
        \Assert\that($rels)->notEmpty()->all()->string();
        \Assert\that($classes)->all()->string();

        $this->rels    = $rels;
        $this->href    = $href;
        $this->classes = $classes;
        $this->title   = $title;
        $this->type    = $type;
    }

    public function getHref() : string
    {
        return $this->href;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function isTemplated()
    {
        return false;
    }

    public function getAttributes()
    {
        return [];
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
