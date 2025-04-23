<?php

namespace App\Controller\api;

use App\Entity\User;
use App\Traits\ValidationTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ApiUserDataController extends AbstractController
{
    use ValidationTrait;

    /**
     * Handles the request for user data.
     *
     * @Route("/api/user/data", name="api_user_data")
     * @param Request $request The request object.
     * @param UserInterface|null $user The authenticated user, if any.
     * @return Response The response object.
     */
    #[Route('/api/user/data', name: 'api_user_data')]
    public function userData(
        Request $request,
        EntityManagerInterface $entityManager,
        UserInterface $user = null
    ): Response
    {
        if(!$this->validateRequest($request, "GET", $user)) {
            return new Response("", Response::HTTP_BAD_REQUEST);
        }

        $userId = $request->get('userId');

        $requestedUser = $entityManager->getRepository(User::class)->find($userId);

        return new JsonResponse([
            "userIdentifier" => $requestedUser->getUserIdentifier(),
        ]);
    }

    /**
     * Check authentication for the user.
     *
     * @Route("/api/user/checkAuthentication", name="api_user_check_authentication")
     *
     * @param Request $request The request object.
     * @param UserInterface|null $user The user object.
     *
     * @return Response The response object.
     */
    #[Route('/api/user/checkAuthentication', name: 'api_user_check_authentication')]
    public function checkAuthentication(
        Request $request,
        EntityManagerInterface $entityManager,
        UserInterface $user = null
    ) : Response {
        if(!$this->validateRequest($request, "GET", $user)) {
            return new Response("", Response::HTTP_BAD_REQUEST);
        }

        $userData = $entityManager->getRepository(User::class)
            ->findOneBy(["username" => $user->getUserIdentifier()]);

        return new JsonResponse([
            "userIdentifier" => $user->getUserIdentifier(),
            "userId" => $userData->getId(),
        ]);
    }
}
