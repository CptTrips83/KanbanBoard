<?php

namespace App\Controller\vue;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class HomeController extends AbstractController
{
    #[Route('/home/{path<.+>}', name: 'app_home', defaults: ['path' => 'home'])]
    public function index(
        #[CurrentUser] User $user,
        string $path = 'board'
    ): Response {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'path' => $path,
        ]);
    }
}
