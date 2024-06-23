<?php declare(strict_types=1);

namespace App\Tests\App\Dto;

use App\Dto\Food\Food;
use App\Dto\Food\FoodTypeEnum;
use App\Dto\Food\Fruit\Fruit;
use App\Dto\Food\Vegetable\Vegetable;
use App\ValueObject\Quantity;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertNotEmpty;

/** @covers \App\Dto\Food\Food */
final class FoodTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testFromArray(?string $expectedException, array $array, ?string $expectedFoodType): void
    {
        if($expectedException) {
            $this->expectException($expectedException);
        }

        $food = Food::fromArray($array);

        if($expectedFoodType) {
            self::assertInstanceOf($expectedFoodType, $food);
        }

        self::assertGreaterThan(0, $food->getId());
        assertNotEmpty($food->getName());
    }

    public function testToString(): void
    {
        $fruit = new Fruit(1, 'Banana', new Quantity(5.1234, 'kg'));
        self::assertEquals('Banana, 5.123 kg', $fruit->toString('kg'));
        self::assertEquals('Banana, 5,123.400 g', $fruit->toString('g'));
    }

    public function dataProvider(): \Generator
    {
        yield 'Valid fruit' => [
            null,
            [
                'id' => 1,
                'name' => 'Banana',
                'type' => 'fruit',
                'quantity' => 500,
                'unit' => 'g'
            ],
            Fruit::class,
        ];
        yield 'Valid vegetable' => [
            null,
            [
                'id' => 1,
                'name' => 'Beans',
                'type' => 'vegetable',
                'quantity' => 500,
                'unit' => 'g'
            ],
            Vegetable::class,
        ];
        yield 'Invalid id' => [
            \InvalidArgumentException::class,
            [
                'id' => -1,
                'name' => 'Beans',
                'type' => 'vegetable',
                'quantity' => 500,
                'unit' => 'g'
            ],
            Vegetable::class,
        ];
        yield 'Invalid name' => [
            \InvalidArgumentException::class,
            [
                'id' => 1,
                'name' => '',
                'type' => 'vegetable',
                'quantity' => 500,
                'unit' => 'g'
            ],
            Vegetable::class,
        ];
        yield 'Invalid food type' => [
            \InvalidArgumentException::class,
            [
                'id' => 1,
                'name' => 'Beef',
                'type' => 'meat',
                'quantity' => 1,
                'unit' => 'kg'
            ],
            null,
        ];
        yield 'Invalid quantity' => [
            \InvalidArgumentException::class,
            [
                'id' => 1,
                'name' => 'Beans',
                'type' => 'vegetable',
                'quantity' => -1,
                'unit' => 'g'
            ],
            Vegetable::class,
        ];
        yield 'Not implemented unit' => [
            \LogicException::class,
            [
                'id' => 1,
                'name' => 'Beans',
                'type' => 'vegetable',
                'quantity' => 10000,
                'unit' => 'mg'
            ],
            Vegetable::class,
        ];
    }
}