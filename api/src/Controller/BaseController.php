<?php
namespace App\Controller;

use App\Exceptions\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    protected function toOkJsonResponse($data): Response
    {
        return new JsonResponse(['status' => 'ok', 'data' => $data]);
    }

    protected function toFailJsonResponse($errors): Response
    {
        return new JsonResponse(['status' => 'fail', 'errors' => $errors]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function parseJsonRequest(Request $request): mixed
    {
        return json_decode($request->getContent(), true);
    }
}