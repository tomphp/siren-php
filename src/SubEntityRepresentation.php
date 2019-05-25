<?php

namespace TomPHP\Siren;

interface SubEntityRepresentation extends EntityRepresentation
{
    public function getRels() : array;
    public function hasRel(string $rel) : bool;
}