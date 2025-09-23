<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AuthController extends AbstractController
{
    #[Route('/login-check', name: 'app_login_check', methods: ['POST'])]
    public function loginCheck(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        // ⚠️ Ici on fait une vérif simple (remplace par une vraie auth plus tard)
        if ($email === "admin_I4@matrix.org" && $password === '4r@gtb7@ph$DFbB9') {

            $session = $request->getSession();
            $session->set('is_logged_in', true);
            
            return new JsonResponse([
                'success' => true,
                'redirect' => $this->generateUrl('app_game_home'),
            ]);
        }

            return new JsonResponse([
            'success' => false,
            'message' => 'Email ou mot de passe incorrect.'
        ]);
    }
}
