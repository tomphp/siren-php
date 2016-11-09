<?php declare(strict_types=1);

namespace TomPHP\Siren;

final class ActionBuilder
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $href;

    /**
     * @var string[]
     */
    private $classes = [];

    /**
     * @var string
     */
    private $method = 'GET';

    /**
     * @var string
     */
    private $title;

    /**
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function setHref(string $href)
    {
        $this->href = $href;

        return $this;
    }

    /**
     * @return $this
     */
    public function addClass(string $name)
    {
        $this->classes[] = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMethod(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Action
     */
    public function build() : Action
    {
        return new Action(
            $this->name,
            $this->href,
            $this->classes,
            $this->method,
            $this->title
        );
    }
}
