<?php declare(strict_types=1);

namespace tests\unit\TomPHP\Siren;

use TomPHP\Siren\Action;

final class ActionTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function on_getName_it_returns_the_name()
    {
        $action = Action::builder()
            ->setName('add-customer')
            ->setHref('http://api.com/customer')
            ->build();

        assertSame('add-customer', $action->getName());
    }

    /** @test */
    public function on_getHref_it_returns_the_href()
    {
        $action = Action::builder()
            ->setName('add-customer')
            ->setHref('http://api.com/customer')
            ->build();

        assertSame('http://api.com/customer', $action->getHref());
    }

    /** @test */
    public function on_getClass_it_returns_all_the_classes()
    {
        $action = Action::builder()
            ->setName('add-customer')
            ->setHref('http://api.com/customer')
            ->addClass('customer')
            ->addClass('item')
            ->build();

        assertSame(['customer', 'item'], $action->getClasses());
    }

    /** @test */
    public function on_hasClass_it_returns_false_if_class_is_not_present()
    {
        $action = Action::builder()
            ->setName('add-customer')
            ->setHref('http://api.com/customer')
            ->addClass('customer')
            ->build();

        assertFalse($action->hasClass('unknown'));
    }

    /** @test */
    public function on_hasClass_it_returns_true_if_class_is_present()
    {
        $action = Action::builder()
            ->setName('add-customer')
            ->setHref('http://api.com/customer')
            ->addClass('customer')
            ->build();

        assertTrue($action->hasClass('customer'));
    }

    /** @test */
    public function on_getMethod_it_returns_GET_if_not_set_otherwise()
    {
        $action = Action::builder()
            ->setName('add-customer')
            ->setHref('http://api.com/customer')
            ->build();

        assertSame('GET', $action->getMethod());
    }

    /** @test */
    public function on_getMethod_it_returns_the_method()
    {
        $action = Action::builder()
            ->setName('add-customer')
            ->setHref('http://api.com/customer')
            ->setMethod('PATCH')
            ->build();

        assertSame('PATCH', $action->getMethod());
    }

    /** @test */
    public function on_getTitle_it_returns_the_title()
    {
        $action = Action::builder()
            ->setName('add-customer')
            ->setHref('http://api.com/customer')
            ->setTitle('Example Title')
            ->build();

        assertSame('Example Title', $action->getTitle());
    }
}
