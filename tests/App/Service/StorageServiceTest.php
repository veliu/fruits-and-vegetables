<?php

namespace App\Tests\App\Service;

use App\Dto\Food\Fruit\Fruit;
use App\Dto\Food\Vegetable\Vegetable;
use App\Service\StorageService;
use PHPUnit\Framework\TestCase;

class StorageServiceTest extends TestCase
{
    public function testReceivingRequest(): void
    {
        $request = file_get_contents('request.json');

        $storageService = new StorageService($request);

        $this->assertNotEmpty($storageService->getRequest());
        $this->assertIsString($storageService->getRequest());
    }

    public function testFilterFoodByType(): void
    {
        $request = file_get_contents('request.json');
        $storageService = new StorageService($request);

        $fruits = $storageService->filterFoodByType(Fruit::class);
        foreach ($fruits as $fruit) {
            self::assertInstanceOf(Fruit::class, $fruit);
        }

        $vegetables = $storageService->filterFoodByType(Vegetable::class);
        foreach ($vegetables as $vegetable) {
            self::assertInstanceOf(Vegetable::class, $vegetable);
        }
    }
}
