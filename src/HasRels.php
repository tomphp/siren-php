<?php declare(strict_types=1);

namespace TomPHP\Siren;

# Both Links and (Sub-)Entities have a $rel array.
# Defines the relationship of the sub-entity to its parent, per Web Linking (RFC5988) and Link Relations.
# MUST be a non-empty array of strings. Required.
trait HasRels
{
    /**
     * @var string[]
     */
    protected $rels;

    public function getRels() : array
    {
        return $this->rels;
    }

    public function hasRel(string $rel) : bool
    {
        return in_array($rel, $this->rels, true);
    }
}