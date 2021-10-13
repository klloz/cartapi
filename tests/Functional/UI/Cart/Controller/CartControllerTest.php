<?php

namespace App\Tests\Functional\UI\Cart\Controller;

use App\Domain\Cart\Cart;
use App\Domain\Product\Currency;
use App\Domain\Product\Product;
use Doctrine\ORM\EntityManagerInterface;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

final class CartControllerTest extends WebTestCase
{
    public EntityManagerInterface $entityManager;
    protected KernelBrowser $client;
    protected ?Router $router;

    public function setUp(): void
    {
        parent::setUp();

        $this->entityManager = $this->getContainer()->get('doctrine')->getManager();
        $this->client = self::createClient();
        $this->router = $this->client->getContainer()->get('router');
    }

    public function testAddProductInvalidData()
    {
        $cart = $this->createNewCart();
        $product = $this->createNewProduct();

        $data = [
            'cartId' => $cart->getId(),
        ];

        $this->client->request(
            'POST',
            $this->router->generate('api_cart_product_add', [
                'cartId' => $cart->getId(),
                'productId' => $product->getId(),
            ]),
            [],
            [],
            [],
            json_encode($data)
        );

        $response = $this->client->getResponse();

        $this->assertSame(400, $response->getStatusCode());
    }

    public function testAddProductException()
    {
        $cart = $this->createNewCart();

        $data = [
            'cartId' => $cart->getId(),
            'productId' => 9999,
        ];

        $this->client->request(
            'POST',
            $this->router->generate('api_cart_product_add', $data),
            [],
            [],
            [],
            json_encode($data)
        );

        $response = $this->client->getResponse();

        $this->assertSame(400, $response->getStatusCode());
    }

    public function testAddProductSuccess()
    {
        $cart = $this->createNewCart();
        $product = $this->createNewProduct();

        $data = [
            'cartId' => $cart->getId(),
        	'productId' => $product->getId(),
        ];

        $this->client->request(
            'POST',
            $this->router->generate('api_cart_product_add', $data),
            [],
            [],
            [],
            json_encode($data)
        );

        $response = $this->client->getResponse();

        $this->assertTrue($response->isSuccessful());
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
