<?php

namespace App\DataFixtures\Cart;

use App\DataFixtures\Product\ProductFixtures;
use App\Domain\Cart\Cart;
use App\Domain\Cart\CartProduct;
use App\Domain\Product\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Rfc4122\UuidV4;

class CartProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var Product $product */
        $product = $this->getReference(ProductFixtures::PRODUCT_REFERENCE);
        /** @var Cart $cart */
        $cart = $this->getReference(CartFixtures::CART_REFERENCE);

        $cartProduct = new CartProduct(UuidV4::uuid4(), $product);
        $cart->addCartProduct($cartProduct);

        $manager->persist($cart);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
            CartFixtures::class,
        ];
    }
}
