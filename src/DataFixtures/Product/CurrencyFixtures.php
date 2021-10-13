<?php

namespace App\DataFixtures\Product;

use App\Domain\Product\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Rfc4122\UuidV4;

class CurrencyFixtures extends Fixture
{
    const CURRENCY_USD_REFERENCE = 'currency-usd';

    public function load(ObjectManager $manager)
    {
        $currency = new Currency(UuidV4::uuid4(), 'USD');
        $manager->persist($currency);
        $manager->flush();

        $this->addReference(self::CURRENCY_USD_REFERENCE, $currency);
    }
}
