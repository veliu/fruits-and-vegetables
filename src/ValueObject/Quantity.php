<?php declare(strict_types=1);

namespace App\ValueObject;

final class Quantity
{
    private float $amount;
    private string $unit;
    public function __construct(float $amount, string $unit)
    {
        $this->amount = $amount;
        $this->unit = strtolower($unit);
    }

    public function __toString(): string
    {
        return sprintf('%s %s', number_format($this->amount, 3), $this->unit);
    }

    public function convertTo(string $demandedUnit): self
    {
        if($demandedUnit === $this->unit) {
            return $this;
        }

        if($demandedUnit === 'g' && $this->unit === 'kg') {
            return new self($this->amount * 1000, $demandedUnit);
        }

        if($demandedUnit === 'kg' && $this->unit === 'g') {
            return new self(($this->amount / 1000), $demandedUnit);
        }

        throw new \LogicException(sprintf('Could not convert "%s" to "%s". Not implemented yet.', $this->unit, $demandedUnit));
    }
}