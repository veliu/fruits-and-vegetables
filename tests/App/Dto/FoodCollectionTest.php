<?php declare(strict_types=1);

namespace App\Tests\App\Dto;

use App\Dto\Food\Fruit\Fruit;
use App\Dto\Food\Fruit\FruitCollection;
use App\Dto\Food\Vegetable\Vegetable;
use App\Dto\Food\Vegetable\VegetableCollection;
use App\ValueObject\Quantity;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

final class FoodCollectionTest extends TestCase
{
    public function testIndexedById(): void
    {
        $fruit1 = new Fruit(3, 'Orange', new Quantity(4, 'kg'));
        $fruit2 = new Fruit(1, 'Banana', new Quantity(1, 'kg'));
        $fruit3 = new Fruit(2, 'Apple', new Quantity(2, 'kg'));

        $collection = (new FruitCollection([$fruit1, $fruit2, $fruit3]))->list();

        self::assertEquals('Banana, 1,000.000 g', $collection[1]);
        self::assertEquals('Apple, 2,000.000 g', $collection[2]);
        self::assertEquals('Orange, 4,000.000 g', $collection[3]);
    }

    public function testAddAndRemove(): void
    {
        $collection = new VegetableCollection([]);

        self::assertEmpty($collection->list());

        $cucumber = new Vegetable(1, 'Cucumber', new Quantity(1, 'kg'));
        $onion = new Vegetable(2, 'Onion', new Quantity(1, 'kg'));

        // Add increased size
        $collection->add($cucumber);
        $collection->add($onion);
        self::assertCount(2, $collection->list());

        // Add again remains same
        $collection->add($cucumber);
        $collection->add($onion);
        self::assertCount(2, $collection->list());

        // Remove decreased size
        $collection->remove($cucumber);
        self::assertCount(1, $collection->list());

        // Remove same again size remains
        $collection->remove($cucumber);
        self::assertCount(1, $collection->list());
    }

    public function testSearch(): void
    {
        $banana = new Fruit(1, 'Banana', new Quantity(1, 'kg'));
        $berry = new Fruit(2, 'Berry', new Quantity(2, 'kg'));
        $cherry = new Fruit(3, 'Cherry', new Quantity(3, 'kg'));
        $collection = new FruitCollection([$banana, $berry, $cherry]);

        $searchResult = $collection->list('banana', 'kg');
        self::assertCount(1, $searchResult);
        assertEquals('Banana, 1.000 kg', $searchResult[1]);

        $searchResult = $collection->list('cherry', 'kg');
        assertCount(2, $searchResult);
        assertEquals('Berry, 2.000 kg', $searchResult[2]);
        assertEquals('Cherry, 3.000 kg', $searchResult[3]);
    }
}