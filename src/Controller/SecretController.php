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
        $entered = (string) $request->request->get('code', '');

        $secret = '230699';
        $secretHash = hash('sha256', $secret);

        $enteredHash = hash('sha256', $entered);

        if (hash_equals($secretHash, $enteredHash)) {
            return $this->json([
                'success' => true,
                'secret' => "L'agent_3 est un allié."
            ]);
        }

        return $this->json(['success' => false], 400);
    }
}