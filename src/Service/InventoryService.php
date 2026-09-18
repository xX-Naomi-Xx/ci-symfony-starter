<?php

namespace App\Service;

use App\Entity\Product;

final class InventoryService
{
    /** @var array<int, int> */
    private array $stock = [];

    /**
     * @param list<Product> $products
     */
    public function __construct(array $products = [])
    {
        foreach ($products as $product) {
            $this->stock[$product->getId()] = $product->getStock();
        }
    }

    public function sell(Product $product, int $quantity): void
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('La quantité vendue doit être strictement positive.');
        }

        $id = $product->getId();
        $available = $this->stock[$id] ?? 0;

        if ($available < $quantity) {
            throw new \InvalidArgumentException('Stock insuffisant pour cette vente.');
        }

        $this->stock[$id] = $available - $quantity;
    }

    public function restock(Product $product, int $quantity): void
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('La quantité réapprovisionnée doit être strictement positive.');
        }

        $id = $product->getId();
        $this->stock[$id] = ($this->stock[$id] ?? 0) + $quantity;
    }

    public function stockOf(Product $product): int
    {
        return $this->stock[$product->getId()] ?? 0;
    }
}
