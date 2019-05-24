<?php

namespace TomPHP\Siren;

trait SirenObject {
    /**
     * @var string[]
     */
    private $classes;

    /**
     * @var string
     */
    private $title;

    /**
     * @return string[]
     */
    public function getClasses() : array
    {
        return $this->classes;
    }

    public function hasClass(string $name) : bool
    {
        return in_array($name, $this->classes, true);
    }

    public function getTitle() : ?string
    {
        return $this->title;
    }
}
