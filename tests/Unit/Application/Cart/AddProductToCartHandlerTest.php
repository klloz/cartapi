<?php

namespace App\Tests\Unit\Application\Cart;

use App\Application\Cart\Command\AddProductToCartCommand;
use App\Application\Cart\Command\AddProductToCartHandler;
use App\Domain\Cart\Cart;
use App\Domain\Cart\CartProduct;
use App\Domain\Cart\CartProducts;
use App\Domain\Cart\Carts;
use App\Domain\Cart\Exception\CartCapacityExceededException;
use App\Domain\Cart\Exception\CartNotFoundException;
use App\Domain\Cart\Exception\ProductInCartLimitExceededException;
use App\Domain\Product\Currency;
use App\Domain\Product\Exception\ProductNotFoundException;
use App\Domain\Product\Product;
use App\Domain\Product\Products;
use Doctrine\ORM\EntityManagerInterface;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Ramsey\Uuid\Rfc4122\UuidV4;

final class AddProductToCartHandlerTest extends WebTestCase
{
    public EntityManagerInterface $entityManager;
    private MockObject $products;
    private MockObject $carts;
    private MockObject $cartProducts;

    public function setUp(): void
    {
        parent::setUp();

        // TODO implement test DB!
        $this->entityManager = $this->getContainer()->get('doctrine')->getManager();
        $this->products = $this->createMock(Products::class);
        $this->carts = $this->createMock(Carts::class);
        $this->cartProducts = $this->createMock(CartProducts::class);
    }

    public function testHandleThrowsCartNotFound(): void
    {
        $this->carts->expects($this->once())
            ->method('findById')
            ->willReturn(null)
        ;

        $this->expectException(CartNotFoundException::class);

        $handler = new AddProductToCartHandler(
            $this->carts,
            $this->products,
            $this->cartProducts
        );

        $handler->handle(
            new AddProductToCartCommand(
                9999,
                9999
            )
        );
    }

    public function testHandleThrowsProductNotFound(): void
    {
        $cart = $this->createNewCart();

        $this->carts->expects($this->once())
            ->method('findById')
            ->with($cart->getId())
            ->willReturn($cart)
        ;

        $this->products->expects($this->once())
            ->method('findById')
            ->willReturn(null)
        ;

        $this->expectException(ProductNotFoundException::class);

        $handler = new AddProductToCartHandler(
            $this->carts,
            $this->products,
            $this->cartProducts
        );

        $handler->handle(
            new AddProductToCartCommand(
                $cart->getId(),
                9999
            )
        );
    }

    public function testHandleThrowsProductLimitExceeded(): void
    {
        $cart = $this->createNewCart();
        $product = $this->createNewProduct();

        $cartProduct = new CartProduct(UuidV4::uuid4(), $product);
        $cart->addCartProduct($cartProduct);

        $i = 0;
        while ($i < 9) {
            $cartProduct->increaseQuantity();
            $i++;
        }

        $this->carts->expects($this->once())
            ->method('findById')
            ->with($cart->getId())
            ->willReturn($cart)
        ;

        $this->products->expects($this->once())
            ->method('findById')
            ->with($product->getId())
            ->willReturn($product)
        ;

        $this->cartProducts->expects($this->once())
            ->method('findProductInCart')
            ->with($product, $cart)
            ->willReturn($cartProduct)
        ;

        $this->expectException(ProductInCartLimitExceededException::class);

        $handler = new AddProductToCartHandler(
            $this->carts,
            $this->products,
            $this->cartProducts
        );

        $handler->handle(
            new AddProductToCartCommand(
                $cart->getId(),
                $product->getId()
            )
        );

        $this->assertSame(2, $cartProduct->getQuantity());
    }

    public function testHandleIncrementSuccess(): void
    {
        $cart = $this->createNewCart();
        $product = $this->createNewProduct();

        $cartProduct = new CartProduct(UuidV4::uuid4(), $product);
        $cart->addCartProduct($cartProduct);

        $this->carts->expects($this->once())
            ->method('findById')
            ->with($cart->getId())
            ->willReturn($cart)
        ;

        $this->products->expects($this->once())
            ->method('findById')
            ->with($product->getId())
            ->willReturn($product)
        ;

        $this->cartProducts->expects($this->once())
            ->method('findProductInCart')
            ->with($product, $cart)
            ->willReturn($cartProduct)
        ;

        $handler = new AddProductToCartHandler(
            $this->carts,
            $this->products,
            $this->cartProducts
        );

        $handler->handle(
            new AddProductToCartCommand(
                $cart->getId(),
                $product->getId()
            )
        );

        $this->assertSame(2, $cartProduct->getQuantity());
    }

    public function testHandleThrowsCartCapacityExceeded(): void
    {
        $cart = $this->createNewCart();
        $product = $this->createNewProduct();

        $i = 0;
        while ($i < 3) {
            $cartProduct = new CartProduct(UuidV4::uuid4(), $this->createNewProduct());
            $cart->addCartProduct($cartProduct);

            $i++;
        }

        $this->carts->expects($this->once())
            ->method('findById')
            ->with($cart->getId())
            ->willReturn($cart)
        ;

        $this->products->expects($this->once())
            ->method('findById')
            ->with($product->getId())
            ->willReturn($product)
        ;

        $this->cartProducts->expects($this->once())
            ->method('findProductInCart')
            ->with($product, $cart)
            ->willReturn(null)
        ;

        $this->expectException(CartCapacityExceededException::class);

        $handler = new AddProductToCartHandler(
            $this->carts,
            $this->products,
            $this->cartProducts
        );

        $handler->handle(
            new AddProductToCartCommand(
                $cart->getId(),
                $product->getId()
            )
        );

        $this->assertSame(2, $cartProduct->getQuantity());
    }

    public function testHandleAddSuccess(): void
    {
        $cart = $this->createNewCart();
        $product = $this->createNewProduct();

        $this->carts->expects($this->once())
            ->method('findById')
            ->with($cart->getId())
            ->willReturn($cart)
        ;

        $this->products->expects($this->once())
            ->method('findById')
            ->with($product->getId())
            ->willReturn($product)
        ;

        $this->cartProducts->expects($this->once())
            ->method('findProductInCart')
            ->with($product, $cart)
            ->willReturn(null)
        ;

        $handler = new AddProductToCartHandler(
            $this->carts,
            $this->products,
            $this->cartProducts
        );

        $handler->handle(
            new AddProductToCartCommand(
                $cart->getId(),
                $product->getId()
            )
        );

        $this->assertSame(1, $cart->getProductsCount());
    }

    private function createNewCart(): Cart
    {
        $cart = new Cart(UuidV4::uuid4());
        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }

    private function createNewProduct(): Product
    {
        $currency = new Currency(UuidV4::uuid4(), 'USD');
        $this->entityManager->persist($currency);

        $product = new Product(UuidV4::uuid4(), UuidV4::uuid4()->toString(), 12.99, $currency);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}
