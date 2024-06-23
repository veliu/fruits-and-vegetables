<?php declare(strict_types=1);

namespace App\Dto\Food\Fruit;

use App\Dto\Food\FoodCollection;

final class FruitCollection extends FoodCollection
{
    /**
     * @param array<int, Fruit> $entries
     */
    public function __construct(array $entries)
    {
        parent::__construct($entries);
    }
}