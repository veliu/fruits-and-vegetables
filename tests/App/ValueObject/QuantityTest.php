<?php declare(strict_types=1);

namespace App\Tests\App\ValueObject;

use App\ValueObject\Quantity;
use PHPUnit\Framework\TestCase;

/** @covers \App\ValueObject\Quantity */
final class QuantityTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testConvertTo(Quantity $quantity, string $convertToUnit, ?string $expectedOutput): void
    {
        if($expectedOutput === null) {
            $this->expectException(\LogicException::class);
        }

        self::assertNotEmpty((string) $quantity);
        $converted = $quantity->convertTo($convertToUnit);
        self::assertEquals($expectedOutput, (string) $converted);
    }

    public function dataProvider(): \Generator
    {
        yield 'Gram to Kilogram' => [new Quantity(12345, 'g'), 'kg', '12.345 kg'];
        yield 'Kilogram to Gram' => [new Quantity(0.12345, 'kg'), 'g', '123.450 g'];
        yield 'Kilogram to invalid unit' => [new Quantity(0.12345, 'kg'), 'mg', null];
    }
}