<?php

namespace App\DataFixtures\Cart;

use App\Domain\Cart\Cart;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Rfc4122\UuidV4;

class CartFixtures extends Fixture
{
    const CART_REFERENCE = 'cart';

    public function load(ObjectManager $manager)
    {
        $cart = new Cart(UuidV4::uuid4());
        $manager->persist($cart);
        $manager->flush();

        $this->addReference(self::CART_REFERENCE, $cart);
    }
}
