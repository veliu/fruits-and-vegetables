<?php declare(strict_types=1);

namespace App\Dto\Food;

class FoodCollection
{
    /** @var array<int, FoodType> */
    private array $entries;

    /** @param array<int, FoodType> $entries */
    public function __construct(array $entries)
    {
        $indexedEntries = [];

        foreach ($entries as $entry) {
            $indexedEntries[$entry->getId()] = $entry;
        }

        $this->entries = $indexedEntries;
    }

    public function add(FoodType $food): void
    {
        $this->entries[$food->getId()] = $food;
    }

    public function remove(FoodType $food): void
    {
        if(array_key_exists($food->getId(), $this->entries)) {
            unset($this->entries[$food->getId()]);
        }
    }

    /** @return FoodType[] */
    public function list(?string $searchTerm = null, string $unit = 'g'): array
    {
        $entries = $this->entries;

        if($searchTerm) {
            $entries = $this->search($searchTerm)->entries;
        }

        return array_map(static fn(FoodType $food) => $food->toString($unit), $entries);
    }

    private function search(string $searchTerm): FoodCollection
    {
        $searchResults = array_values(array_filter(array_map(function (FoodType $food) use ($searchTerm) {
            similar_text($searchTerm, $food->getName(), $equalityInPercent);
            return $equalityInPercent > 70 ? $food : null;
        }, $this->entries)));

        return new self($searchResults);
    }
}