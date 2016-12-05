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
     * @var Field[]
     */
    private $fields = [];

    /**
     * @return $this
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function setHref(string $href) : self
    {
        $this->href = $href;

        return $this;
    }

    /**
     * @return $this
     */
    public function addClass(string $name) : self
    {
        $this->classes[] = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMethod(string $method) : self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return $this
     */
    public function setTitle(string $title) : self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return $this
     */
    public function addField(Field $field) : self
    {
        $this->fields[] = $field;

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
            $this->title,
            $this->fields
        );
    }
}
