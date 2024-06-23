<?php declare(strict_types=1);

namespace App\Dto\Food\Vegetable;

use App\Dto\Food\FoodCollection;

final class VegetableCollection extends FoodCollection
{
    /**
     * @param array<int, Vegetable> $entries
     */
    public function __construct(array $entries)
    {
        parent::__construct($entries);
    }
}