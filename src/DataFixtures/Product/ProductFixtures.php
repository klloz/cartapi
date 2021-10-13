<?php

namespace App\DataFixtures\Product;

use App\Domain\Product\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Rfc4122\UuidV4;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    const PRODUCT_REFERENCE = 'product';

    public function load(ObjectManager $manager)
    {
        $currency = $this->getReference(CurrencyFixtures::CURRENCY_USD_REFERENCE);

        $data = [
            [
                'title' => 'Fallout',
                'price' => 199,
                'currency' => $currency,
            ],
            [
                'title' => 'Don\'t Starve',
                'price' => 299,
                'currency' => $currency,
            ],
            [
                'title' => 'Baldur\'s Gate',
                'price' => 399,
                'currency' => $currency,
            ],
            [
                'title' => 'Icewind Dale',
                'price' => 499,
                'currency' => $currency,
            ],
            [
                'title' => 'Bloodborne',
                'price' => 599,
                'currency' => $currency,
            ],
        ];

        foreach ($data as $item) {
            $product = new Product(UuidV4::uuid4(), $item['title'], $item['price'], $item['currency']);
            $manager->persist($product);
        }

        $manager->flush();

        $this->addReference(self::PRODUCT_REFERENCE, $product);
    }

    public function getDependencies(): array
    {
        return [
            CurrencyFixtures::class,
        ];
    }
}
