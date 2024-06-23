<?php declare(strict_types=1);

namespace App\Dto\Food;

use App\ValueObject\Quantity;

interface FoodType
{
    public function getId(): int;
    public function getName(): string;
    public function getType(): FoodTypeEnum;
    public function getQuantity(): Quantity;
    public function toString(string $unit): string;
}