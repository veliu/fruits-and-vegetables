<?php declare(strict_types=1);

namespace App\Dto\Food;

use App\Dto\Food\Fruit\Fruit;
use App\Dto\Food\Vegetable\Vegetable;
use App\ValueObject\Quantity;
use Webmozart\Assert\Assert;

abstract class Food
{
    protected int $id;
    protected string $name;
    protected Quantity $quantity;
    public function __construct(int $id, string $name, Quantity $quantity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
    }

    abstract function getType(): FoodTypeEnum;

    /** @throws \InvalidArgumentException|\LogicException */
    public static function fromArray(array $array): FoodType
    {
        Assert::keyExists($array, 'id');
        Assert::keyExists($array, 'name');
        Assert::keyExists($array, 'type');
        Assert::keyExists($array, 'quantity');
        Assert::keyExists($array, 'unit');

        $id = $array['id'];
        $name = $array['name'];
        $type = $array['type'];
        $quantity = $array['quantity'];
        $unit = $array['unit'];

        Assert::stringNotEmpty($name);
        Assert::stringNotEmpty($type);
        Assert::stringNotEmpty($unit);
        Assert::positiveInteger($id);
        Assert::positiveInteger($quantity);

        $foodType = FoodTypeEnum::tryFrom($type);

        $gramQuantity = (new Quantity($quantity, $unit))->convertTo('g');

        return match ($foodType->getValue()) {
            FoodTypeEnum::fruit()->getValue() => new Fruit($id, $name, $gramQuantity),
            FoodTypeEnum::vegetable()->getValue() => new Vegetable($id, $name, $gramQuantity),
            default => throw new \LogicException(sprintf('Food of type "%s" is not implemented.', $foodType))
        };
    }

    public function toString(string $unit): string
    {
        return sprintf('%s, %s', $this->name, $this->quantity->convertTo($unit));
    }
}