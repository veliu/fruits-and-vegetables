<?php declare(strict_types=1);

namespace App\Service;

use App\Dto\Food\Food;
use App\Dto\Food\FoodType;
use Webmozart\Assert\Assert;

class StorageService
{
    protected string $request = '';

    public function __construct(
        string $request
    )
    {
        $this->request = $request;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    /** @return FoodType[] */
    private function parseFood(): array
    {
        try {
            $arrayRequest = json_decode($this->request, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \InvalidArgumentException('Json request could not be decoded.', 422, $e);
        }

        return array_values(array_map(static fn(array $array) => Food::fromArray($array), $arrayRequest));
    }

    /**
     * @template T
     * @param class-string<T> $type
     * @return T[]
     */
    public function filterFoodByType(string $type): array
    {
        $collection = array_filter(
            $this->parseFood(),
            static fn(FoodType $food) => $food instanceof $type
        );

        Assert::allIsInstanceOf($collection, $type);

        return $collection;
    }
}
