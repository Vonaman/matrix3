<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameOverController extends AbstractController
{
    #[Route('/game-over', name: 'app_game_over')]
    public function index(): Response
    {
        return $this->render('game_over/index.html.twig', [
            'controller_name' => 'GameOverController',
        ]);
    }
}
