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

    /** @test */
    public function on_getClasses_it_returns_the_classes()
    {
        $link = new Link(['next'], 'http://api.com/next', ['class-one', 'class-two']);

        assertSame(['class-one', 'class-two'], $link->getClasses());
    }

    /** @test */
    public function on_getTitle_it_returns_the_title()
    {
        $link = new Link(['next'], 'http://api.com/next', [], 'Next Page');

        assertSame('Next Page', $link->getTitle());
    }

    /** @test */
    public function on_getType_it_returns_the_type()
    {
        $link = new Link(['next'], 'http://api.com/next', [], null, 'application/json');

        assertSame('application/json', $link->getType());
    }

    /** @test */
    public function on_asArray_it_returns_an_array_with_minium_values()
    {
        $link = new Link(['self'], 'http://api.com/self');

        assertSame(
            [
                'rel' => ['self'],
                'href' => 'http://api.com/self',
            ],
            $link->toArray()
        );
    }

    /** @test */
    public function on_asArray_it_returns_an_array_will_all_values()
    {
        $link = new Link(
            ['self'],
            'http://api.com/self',
            ['product'],
            'Product',
            'application/json'
        );

        assertSame(
            [
               'rel' => ['self'],
               'href' => 'http://api.com/self',
               'class' => ['product'],
               'title' => 'Product',
               'type' => 'application/json',
            ],
            $link->toArray()
        );
    }
}
