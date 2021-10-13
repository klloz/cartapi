<?php

namespace App\Shared\UI\Controller\Rest;

use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseController extends AbstractController
{
    protected CommandBus $commandBus;
    protected ValidatorInterface $validator;

    public function __construct(CommandBus $commandBus, ValidatorInterface $validator)
    {
        $this->commandBus = $commandBus;
        $this->validator = $validator;
    }

    protected function createFormErrorsResponse(FormInterface $form): JsonResponse
    {
        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getCause()->getPropertyPath()] = $error->getMessage();
        }

        return new JsonResponse($errors,Response::HTTP_BAD_REQUEST);
    }
}
