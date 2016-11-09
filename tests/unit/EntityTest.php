<?php declare(strict_types=1);

namespace tests\unit\TomPHP\Siren;

use TomPHP\Siren\Entity;
use TomPHP\Siren\Exception\NotFound;
use TomPHP\Siren\Link;
use TomPHP\Siren\Action;

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
    public function on_hasLink_it_returns_false_if_a_link_with_the_rel_is_not_present()
    {
        $entity = Entity::builder()
            ->addLink('previous', 'http://api.com/previous')
            ->build();

        assertFalse($entity->hasLink('next'));
    }

    /** @test */
    public function on_hasLink_it_returns_false_if_a_link_with_the_rel_is_present()
    {
        $entity = Entity::builder()
            ->addLink('next', 'http://api.com/next')
            ->build();

        assertTrue($entity->hasLink('next'));
    }

    /** @test */
    public function on_getLinks_it_returns_all_added_links()
    {
        $entity = Entity::builder()
            ->addLink('next', 'http://api.com/next')
            ->addLink('previous', 'http://api.com/previous')
            ->build();

        assertEquals(
            [
                new Link(['next'], 'http://api.com/next'),
                new Link(['previous'], 'http://api.com/previous'),
            ],
            $entity->getLinks()
        );
    }

    /** @test */
    public function on_getLink_it_returns_the_link_by_rel()
    {
        $entity = Entity::builder()
            ->addLink('next', 'http://api.com/next')
            ->build();

        assertEquals(new Link(['next'], 'http://api.com/next'), $entity->getLink('next'));
    }

    /** @test */
    public function on_getLink_it_throws_NotFound_if_the_link_is_not_found()
    {
        $entity = Entity::builder()
            ->addLink('next', 'http://api.com/next')
            ->build();

        $this->setExpectedException(
            NotFound::class,
            'Link "previous" was not found.',
            NotFound::LINK
        );

        $entity->getLink('previous');
    }

    /** @test */
    public function on_getTitle_it_returns_the_title()
    {
        $entity = Entity::builder()
            ->setTitle('The Title')
            ->build();

        assertSame('The Title', $entity->getTitle());
    }

    /** @test */
    public function on_getActions_it_returns_the_actions()
    {
        $action = Action::builder()
            ->setName('example-action')
            ->setHref('http://api.com/example')
            ->build();

        $entity = Entity::builder()
            ->addAction($action)
            ->build();

        assertEquals([$action], $entity->getActions());
    }

    /** @test */
    public function on_hasAction_it_returns_false_if_there_is_not_a_matching_action()
    {
        $action = Action::builder()
            ->setName('example-action')
            ->setHref('http://api.com/example')
            ->build();

        $entity = Entity::builder()
            ->addAction($action)
            ->build();

        assertFalse($entity->hasAction('unknown-action'));
    }

    /** @test */
    public function on_hasAction_it_returns_true_if_there_is_a_matching_action()
    {
        $action = Action::builder()
            ->setName('example-action')
            ->setHref('http://api.com/example')
            ->build();

        $entity = Entity::builder()
            ->addAction($action)
            ->build();

        assertTrue($entity->hasAction('example-action'));
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

    /** @test */
    public function on_toJson_it_returns_a_json_string()
    {
        $entity = Entity::builder()
            ->addClass('example-class')
            ->addProperties([
                'a' => 1,
                'b' => 2,
            ])
            ->build();

        assertSame(json_encode($entity->toArray()), $entity->toJson());
    }
}
