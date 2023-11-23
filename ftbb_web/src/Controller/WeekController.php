<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeekController extends AbstractController
{
    /**
     * @Route("/week", name="week")
     */
    public function index(): Response
    {
        return $this->render('week/index.html.twig', [
            'controller_name' => 'WeekController',
        ]);
    }
}
