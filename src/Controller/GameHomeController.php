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

        if (!$session->get('is_logged_in') || !$session->has('endtime')) {
            return $this->redirectToRoute('app_home');
        }

        $endTime = $session->get('endtime');

        if (!$session->has('agents')) {
            $session->set('agents', $this->randomAgent());
        }

        $agents = $session->get('agents');
        $innocents = array_values(array_filter($agents, fn($a) => !$a['parasite']));
        shuffle($innocents);

        if(!$session->has('innocents')){
            $session->set('innocents', $innocents);
        }

        $hash = $this->getSecretHash();

        return $this->render('game_home/index.html.twig', [
            'controller_name' => 'GameHomeController',
            'agents' => $agents,
            'innocents' => $innocents,
            'endtime' => $endTime,
            'hash' => $hash,
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

        if(count($agents) == 1){
            return $this->redirectToRoute('app_game_over');
        }

        return $this->redirectToRoute('app_game_home');
    }
    
    private function getSecretHash(): string
    {
        $secretCode = '230699';
        return hash('sha256', $secretCode);
    }

    private function randomAgent(): array
    {
        $tabAgent = [];
        $agentPara = rand(1, 6);

        $agentName = ["Eliott", "Axel", "Momo", "Loïs", "Thomas", "Behnam"];
        shuffle($agentName);

        for ($i = 1; $i <= 6; $i++) {
            $tabAgent[] = [
                'id' => $i,
                'name' => $agentName[$i - 1],
                'parasite' => ($i === $agentPara),
            ];
        }

        return $tabAgent;
    }
}
