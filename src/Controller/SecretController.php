<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class SecretController extends AbstractController
{
    #[Route('/verify-secret', name: 'app_verify_secret', methods: ['POST'])]
    public function verify(Request $request): Response
    {

        $session = $request->getSession();
        $entered = (string) $request->request->get('code', '');

        $secret = '230699';
        $secret2 = '372438';
        $secretHash = hash('sha256', $secret);
        $secretHash2 = hash('sha256', $secret2);

        $enteredHash = hash('sha256', $entered);

        if (hash_equals($secretHash, $enteredHash) || hash_equals($secretHash2, $enteredHash)) {
            $innocents = $session->get('innocents', []);

            if(hash_equals($secretHash, $enteredHash)){     
                if (!empty($innocents) && isset($innocents[2])) {
                    $agentName = $innocents[2]['name'];
                } else {
                    $agentName = 'Inconnu';
                }
            } else if(hash_equals($secretHash2, $enteredHash)){
                if (!empty($innocents) && isset($innocents[3])) {
                    $agentName = $innocents[3]['name'];
                } else {
                    $agentName = 'Inconnu';
                }
            }


            return $this->json([
                'success' => true,
                'secret' => $agentName . " est un allié."
            ]);
        }

        return $this->json(['success' => false], 400);
    }
}