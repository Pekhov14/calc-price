<?php

namespace App\Service;

use App\Entity\Country;
use App\Entity\Product;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\RuntimeException;

readonly class ProductService
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function calculatePrice(int $productId, string $countryCode): float
    {
        $productRepository = $this->entityManager->getRepository(Product::class);
        $countryRepository = $this->entityManager->getRepository(Country::class);

        try {
            $taxRate = $countryRepository->findOneBy(['code' => $countryCode])?->getTax();
        } catch (NotNullConstraintViolationException) {
            throw new RuntimeException('Aaaaa 😱');
        }

        $price = ($productRepository->findOneBy(['id' => $productId])?->getPrice()) ?? 0;

        return $price * (1 + $taxRate / 100);
    }

    public  function getProductChoices(): array
    {
        $productRepository = $this->entityManager->getRepository(Product::class);
        $items             = $productRepository->findAll();
        $products          = [];

        foreach ($items as $item) {
            $products[$item->getName()] = $item->getId();
        }

        return $products;
    }
}