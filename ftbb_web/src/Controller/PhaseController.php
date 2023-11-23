<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhaseController extends AbstractController
{
    /**
     * @Route("/phase", name="phase")
     */
    public function index(): Response
    {
        return $this->render('phase/index.html.twig', [
            'controller_name' => 'PhaseController',
        ]);
    }
}
