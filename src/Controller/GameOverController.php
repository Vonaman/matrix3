<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameOverController extends AbstractController
{
    #[Route('/game-over', name: 'app_game_over')]
    public function index(Request $request): Response
    {

        $session = $request->getSession();

        if ($session->has('endtime') || $session->get('endtime') > time()) {
            $session->set('endtime', time() + 0);
        }

        $endtime = $session->get('endtime');

        $agents = $session->get('agents', []);

        if($agents[0]['parasite'] == true && count($agents) == 1){
            $victoire = true;
        }

        $victoire = false;

        return $this->render('game_over/index.html.twig', [
            'controller_name' => 'GameOverController',
            'endtime' => $endtime,
            'victoireCheck' => $victoire,
        ]);
    }
}
