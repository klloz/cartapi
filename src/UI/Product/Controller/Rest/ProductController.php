<?php

namespace App\UI\Product\Controller\Rest;

use App\Application\Product\Command\CreateProductCommand;
use App\Application\Product\Command\EditProductCommand;
use App\Application\Product\Command\RemoveProductCommand;
use App\Infrastructure\Product\Query\DoctrineProductListQuery;
use App\Shared\Application\Query\PagedQueryParameters;
use App\Shared\UI\Controller\Rest\BaseController;
use App\Shared\UI\Form\PagedQueryParametersType;
use App\UI\Product\Form\CreateProductType;
use App\UI\Product\Form\EditProductType;
use App\UI\Product\Form\RemoveProductType;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/product")
 */
class ProductController extends BaseController
{
    /**
     * @Route("", name="api_product_list", methods={"GET"})
     *
     * @param Request $request
     * @param DoctrineProductListQuery $query
     * @return Response
     */
    public function listAction(Request $request, DoctrineProductListQuery $query): Response
    {
        $form = $this->createForm(PagedQueryParametersType::class);
        $form->submit($request->query->all());

        if ($form->isValid()) {
            try {
                /** @var PagedQueryParameters $params */
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
     * @Route("", name="api_product_create", methods={"POST"})
     *
     * @var Request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $form = $this->createForm(CreateProductType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                /** @var CreateProductCommand $command */
                $command = $form->getData();
                $this->commandBus->handle($command);

                return new JsonResponse($command->uuid->toString());
            } catch (Exception $e) {
                return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        return $this->createFormErrorsResponse($form);
    }

    /**
     * @Route("/{id}", name="api_product_edit", methods={"PUT"})
     *
     * @param Request $request
     * @return Response
     */
    public function editAction(Request $request): Response
    {
        $form = $this->createForm(EditProductType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                /** @var EditProductCommand $command */
                $command = $form->getData();
                $this->commandBus->handle($command);

                return new JsonResponse('Product updated.');
            } catch (Exception $e) {
                return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        return $this->createFormErrorsResponse($form);
    }

    /**
     * @Route("/{id}", name="api_product_delete", methods={"DELETE"})
     *
     * @param Request $request
     * @return Response
     */
    public function removeAction(Request $request): Response
    {
        $form = $this->createForm(RemoveProductType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                /** @var RemoveProductCommand $command */
                $command = $form->getData();
                $this->commandBus->handle($command);

                return new JsonResponse("Product removed.");
            } catch (Exception $e) {
                return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        return $this->createFormErrorsResponse($form);
    }
}
