<?php declare(strict_types=1);

namespace TomPHP\Siren;

use Assert\Assertion;

final class Link
{
    /**
     * @var string[]
     */
    private $rels;

    /**
     * @var string
     */
    private $href;

    /**
     * @param string[] $rels
     * @param string   $href
     */
    public function __construct(array $rels, string $href)
    {
        \Assert\that($rels)->notEmpty()->all()->string();

        $this->rels = $rels;
        $this->href = $href;
    }

    /**
     * @return string[]
     */
    public function getRels() : array
    {
        return $this->rels;
    }

    public function hasRel(string $rel) : bool
    {
        return in_array($rel, $this->rels);
    }
}
