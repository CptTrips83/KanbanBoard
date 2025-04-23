<?php

namespace App\Controller\api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiTestController extends AbstractController
{
    #[Route('/api/test', name: 'api_test')]
    public function index(
        Request $request,
        UserInterface $user = null
    ): Response
    {
        if($request->isXmlHttpRequest()) {

            if ($user == null) {
                return new Response("",Response::HTTP_UNAUTHORIZED);
            }

            if ($request->isMethod("POST")) {
                dump($request->getContent());
            }

            return new JsonResponse([
               "success" => true,
               "user" => $user->getUserIdentifier()
            ]);
        }

        return new Response("",Response::HTTP_BAD_REQUEST);
    }
}
