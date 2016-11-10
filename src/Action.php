<?php declare(strict_types=1);

namespace TomPHP\Siren;

final class Action
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
    private $classes;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $title;

    public static function builder() : ActionBuilder
    {
        return new ActionBuilder();
    }

    public static function fromArray(array $array) : self
    {
        return new self(
            $array['name'],
            $array['href'],
            $array['class'] ?? [],
            $array['method'] ?? 'GET',
            $array['title'] ?? null
        );
    }

    /**
     * @param string   $name
     * @param string   $href
     * @param string[] $classes
     * @param string   $method
     *
     * @internal
     */
    public function __construct(
        string $name,
        string $href,
        array $classes,
        string $method,
        string $title = null
    ) {
        $this->name = $name;
        $this->href = $href;
        $this->classes = $classes;
        $this->method = $method;
        $this->title = $title;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getHref() : string
    {
        return $this->href;
    }

    /**
     * @return string[]
     */
    public function getClasses() : array
    {
        return $this->classes;
    }

    public function hasClass(string $name) : bool
    {
        return in_array($name, $this->classes);
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function toArray() : array
    {
        $result = [
            'name' => $this->name,
            'href' => $this->href,
            'method' => $this->method,
        ];

        if (count($this->classes)) {
            $result['class'] = $this->classes;
        }

        if (!is_null($this->title)) {
            $result['title'] = $this->title;
        }

        return $result;
    }
}
