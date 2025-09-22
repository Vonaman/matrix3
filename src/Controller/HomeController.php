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

        // if (!$session->has('endtime') || $session->get('endtime') == 1758531137) {
            // on fixe end_time = maintenant + 1h
            $session->set('endtime', time() + 1800);
        // }

        // dd($session->get('endtime'));

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
