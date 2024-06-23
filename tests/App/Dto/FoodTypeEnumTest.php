<?php declare(strict_types=1);

namespace App\Tests\App\Dto;

use App\Dto\Food\FoodTypeEnum;
use PHPUnit\Framework\TestCase;

/** @covers \App\Dto\Food\FoodTypeEnum */
final class FoodTypeEnumTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testTryFrom(string $value, bool $isValid): void
    {
        if(!$isValid) {
            $this->expectException(\InvalidArgumentException::class);
        }

        $enum = FoodTypeEnum::tryFrom($value);

        self::assertEquals($value, $enum->getValue());
    }

    public function dataProvider(): \Generator
    {
        foreach (FoodTypeEnum::VALID_VALUES as $validValue) {
            yield $validValue => [$validValue, true];
        }

        yield 'meat' => ['meat', false];
    }
}