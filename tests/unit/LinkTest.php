<?php declare(strict_types=1);

namespace tests\unit\TomPHP\Siren;

use TomPHP\Siren\Link;

final class LinkTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_must_have_at_least_one_rel()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Link([], 'http://api.com');
    }

    /** @test */
    public function on_hasRel_it_returns_true_if_the_rel_is_pesent()
    {
        $link = new Link(['self'], 'http://api.com');

        assertTrue($link->hasRel('self'));
    }

    /** @test */
    public function on_hasRel_it_returns_false_if_the_rel_is_not_pesent()
    {
        $link = new Link(['next'], 'http://api.com/next');

        assertFalse($link->hasRel('self'));
    }
}
