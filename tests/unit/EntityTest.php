<?php declare(strict_types=1);

namespace tests\unit\TomPHP\Siren;

use TomPHP\Siren\Entity;
use TomPHP\Siren\Exception\NotFound;

final class EntityTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function on_getClasses_it_returns_the_classes()
    {
        $entity = Entity::builder()
            ->addClass('class-a')
            ->addClass('class-b')
            ->build();

        assertSame(['class-a', 'class-b'], $entity->getClasses());
    }

    /** @test */
    public function on_getClasses_return_only_one_of_each_class()
    {
        $entity = Entity::builder()
            ->addClass('class-a')
            ->addClass('class-a')
            ->build();

        assertSame(['class-a'], $entity->getClasses());
    }

    /** @test */
    public function on_hasClass_it_returns_false_if_the_class_is_not_present()
    {
        $entity = Entity::builder()
            ->build();

        assertFalse($entity->hasClass('example-class'));
    }

    /** @test */
    public function on_hasClass_it_returns_true_if_the_class_is_present()
    {
        $entity = Entity::builder()
            ->addClass('example-class')
            ->build();

        assertTrue($entity->hasClass('example-class'));
    }

    /** @test */
    public function on_getProperties_it_returns_all_properties()
    {
        $entity = Entity::builder()
            ->addProperties(['a' => 1, 'b' => 2])
            ->build();

        assertSame(['a' => 1, 'b' => 2], $entity->getProperties());
    }

    /** @test */
    public function on_hasProperty_it_returns_false_if_the_property_is_not_present()
    {
        $entity = Entity::builder()
            ->build();

        assertFalse($entity->hasProperty('example-property'));
    }

    /** @test */
    public function on_hasProperty_it_returns_true_if_the_property_is_present()
    {
        $entity = Entity::builder()
            ->addProperty('example-property', 'some value')
            ->build();

        assertTrue($entity->hasProperty('example-property'));
    }

    /** @test */
    public function on_hasProperty_it_returns_true_for_a_null_value_property()
    {
        $entity = Entity::builder()
            ->addProperty('example-property', null)
            ->build();

        assertTrue($entity->hasProperty('example-property'));
    }

    /** @test */
    public function on_getProperty_it_throws_an_exception_if_property_is_not_found()
    {
        $entity = Entity::builder()
            ->build();

        $this->expectException(NotFound::class);

        $entity->getProperty('example-property');
    }

    /** @test */
    public function on_getProperty_it_returns_the_property_value()
    {
        $entity = Entity::builder()
            ->addProperty('example-property', 'property-value')
            ->build();

        assertSame('property-value', $entity->getProperty('example-property'));
    }

    /** @test */
    public function on_getProperty_it_returns_a_null_value_property()
    {
        $entity = Entity::builder()
            ->addProperty('example-property', null)
            ->build();

        assertNull($entity->getProperty('example-property'));
    }

    /** @test */
    public function on_getPropertyOr_it_returns_the_default_if_property_is_not_found()
    {
        $entity = Entity::builder()
            ->build();

        assertSame('default-value', $entity->getPropertyOr('example-property', 'default-value'));
    }

    /** @test */
    public function on_getPropertyOr_it_returns_the_property_value()
    {
        $entity = Entity::builder()
            ->addProperty('example-property', 'property-value')
            ->build();

        assertSame('property-value', $entity->getPropertyOr('example-property', 'default-value'));
    }

    /** @test */
    public function on_toArray_it_converts_to_an_array()
    {
        $entity = Entity::builder()
            ->addClass('example-class')
            ->addProperties([
                'a' => 1,
                'b' => 2,
            ])
            ->build();

        assertSame(
            [
                'class' => ['example-class'],
                'properties' => [
                    'a' => 1,
                    'b' => 2,
                ],
            ],
            $entity->toArray()
        );
    }
}
