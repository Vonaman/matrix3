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

        if (!$session->has('endtime') || $session->get('endtime') <= time()) {
            $session->set('endtime', time() + 3600);
        }

        $endTime =  $session->get('endtime');

        if($session->has('agents')){
            $session->remove('agents');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'endtime' => $endTime,
        ]);
    }
}
