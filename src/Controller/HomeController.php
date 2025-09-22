<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();

        if (!$session->has('end_time')) {
            // on fixe end_time = maintenant + 1h
            $session->set('end_time', time() + 3600);
        }

        $endTime =  $session->get('end_time');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'end_time' => $endTime,
        ]);
    }
}
