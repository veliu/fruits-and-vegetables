<?php declare(strict_types=1);

namespace App\Dto\Food;

use Webmozart\Assert\Assert;

final class FoodTypeEnum
{
    public const VALID_VALUES = ['fruit', 'vegetable'];
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /** @throws \InvalidArgumentException */
    public static function tryFrom(string $value): self
    {
        Assert::inArray($value, self::VALID_VALUES);

        return new self($value);
    }

    public static function fruit(): self
    {
        return new self('fruit');
    }

    public static function vegetable(): self
    {
        return new self('vegetable');
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(FoodTypeEnum $foodType): bool
    {
        return $foodType->value === $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}