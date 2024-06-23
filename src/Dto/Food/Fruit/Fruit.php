<?php declare(strict_types=1);

namespace App\Dto\Food\Fruit;

use App\Dto\Food\Food;
use App\Dto\Food\FoodType;
use App\Dto\Food\FoodTypeEnum;
use App\ValueObject\Quantity;

final class Fruit extends Food implements FoodType
{
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): FoodTypeEnum
    {
        return FoodTypeEnum::fruit();
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }
}