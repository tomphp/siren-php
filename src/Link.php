<?php declare(strict_types=1);

namespace TomPHP\Siren;

final class Link
{
    /**
     * @var string
     */
    private $rel;

    /**
     * @var string
     */
    private $href;

    public function __construct(string $rel, string $href)
    {
        $this->rel = $rel;
        $this->href = $href;
    }

    public function getRel() : string
    {
        return $this->rel;
    }
}
