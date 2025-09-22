<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class GameHomeController extends AbstractController
{
    #[Route('/game/home', name: 'app_game_home')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();

        if (!$session->get('is_logged_in') || !$session->has('end_time')) {
            return $this->redirectToRoute('app_home');
        }

        $endTime = $session->get('timer_end');

        if (!$session->has('agents')) {
            $session->set('agents', $this->randomAgent());
        }

        $agents = $session->get('agents');

        return $this->render('game_home/index.html.twig', [
            'controller_name' => 'GameHomeController',
            'agents' => $agents,
            'endTime' => $endTime,

        ]);
    }

    #[Route('/game/eliminate', name: 'app_eliminate_agent', methods: ['POST'])]
    public function eliminate(Request $request): Response
    {
        $session = $request->getSession();
        $agents = $session->get('agents', []);

        $id = (int) $request->request->get('agent_id');

        $agents = array_filter($agents, fn($agent) => $agent['id'] !== $id);
        $agents = array_values($agents);

        $session->set('agents', $agents);

        return $this->redirectToRoute('app_game_home');
    }

    private function randomAgent(): array
    {
        $tabAgent = array();
        $agentPara = rand(1, 6);

        for ($i = 1; $i <= 6; $i++) {
            $tabAgent[] = [
                'id' => $i,
                'name' => "agent_" . $i,
                'parasite' => ($i === $agentPara),
            ];
        }

        return $tabAgent;
    }
}
