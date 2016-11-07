<?php declare(strict_types=1);

namespace tests\unit\TomPHP\Siren;

use TomPHP\Siren\Entity;

final class EntityTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_converts_to_a_json_string()
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
