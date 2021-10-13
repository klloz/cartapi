<?php

namespace App\UI\Cart\Controller\Rest;

use App\Application\Cart\Command\AddProductToCartCommand;
use App\Application\Cart\Command\CreateCartCommand;
use App\Application\Cart\Command\RemoveProductFromCartCommand;
use App\Application\Cart\Query\CartDetails\CartDetailsQueryParameters;
use App\Infrastructure\Cart\Query\DoctrineCartDetailsQuery;
use App\Shared\UI\Controller\Rest\BaseController;
use App\UI\Cart\Form\AddProductToCartType;
use App\UI\Cart\Form\CartDetailsQueryParametersType;
use App\UI\Cart\Form\RemoveProductFromCartType;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/cart")
 */
class CartController extends BaseController
{
    /**
     * @Route("/{id}", name="api_cart_details", methods={"GET"})
     *
     *
     * @param Request $request
     * @param DoctrineCartDetailsQuery $query
     * @return Response
     */
    public function detailsAction(Request $request, DoctrineCartDetailsQuery $query): Response
    {
        $form = $this->createForm(CartDetailsQueryParametersType::class);
        $form->submit($request->query->all());

        if ($form->isValid()) {
            try {
                /** @var CartDetailsQueryParameters $params */
                $params = $form->getData();
                $results = json_encode($query->execute($params));

                return new JsonResponse($results);
            } catch (Exception $e) {
                return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        return $this->createFormErrorsResponse($form);
    }

    /**
     * @Route("", name="api_cart_create", methods={"POST"})
     *
     * @var Request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        try {
            $command = new CreateCartCommand();
            $this->commandBus->handle($command);

            return new JsonResponse($command->uuid->toString());
        } catch (Exception $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/{cartId}/product/{productId}", name="api_cart_product_add", methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function addProductAction(Request $request): Response
    {
        $form = $this->createForm(AddProductToCartType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                /** @var AddProductToCartCommand $command */
                $command = $form->getData();
                $this->commandBus->handle($command);

                return new JsonResponse('Product added.');
            } catch (Exception $e) {
                return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        return $this->createFormErrorsResponse($form);
    }

    /**
     * @Route("/{cartId}/product/{productId}", name="api_cart_product_remove", methods={"DELETE"})
     *
     * @param Request $request
     * @return Response
     */
    public function removeProductAction(Request $request): Response
    {
        $form = $this->createForm(RemoveProductFromCartType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                /** @var RemoveProductFromCartCommand $command */
                $command = $form->getData();
                $this->commandBus->handle($command);

                return new JsonResponse('Product removed.');
            } catch (Exception $e) {
                return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        return $this->createFormErrorsResponse($form);
    }
}
