<?php declare(strict_types=1);

namespace tests\unit\TomPHP\Siren;

use TomPHP\Siren\Entity;

final class EntityBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function on_addProperies_it_extends_current_properties()
    {
        // Builder test
        $entity = Entity::builder()
            ->addProperties(['a' => 'one', 'b' => 2])
            ->addProperties(['b' => 'two', 'c' => 'three'])
            ->build();

        assertSame(
            ['a' => 'one', 'b' => 'two', 'c' => 'three'],
            $entity->getProperties()
        );
    }

    /** @test */
    public function on_addProperty_it_adds_it_to_the_list()
    {
        $entity = Entity::builder()
            ->addProperty('a', 'one')
            ->addProperty('b', 'two')
            ->build();

        assertSame(['a' => 'one', 'b' => 'two'], $entity->getProperties());
    }
}
