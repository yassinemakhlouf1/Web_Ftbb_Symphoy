<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use  App\Entity\Classement;
use Knp\Snappy\Pdf;


class ClassementController extends AbstractController
{
    private $snappy;
public function __construct(Pdf $snappy)
{
    $this->snappy = $snappy;
}
    /**
     * @Route("/classement", name="classement")
     */
    public function index(): Response
    {
        return $this->render('classement/index.html.twig', [
            'controller_name' => 'ClassementController',
        ]);
    }

    /**
     * @Route("/ShowClassement", name="ShowClassement")
     */
    public function ShowClassement(): Response
    {

        
        $repository = $this->getDoctrine()->getRepository(Classement::class);


        $classements = $repository->findAll();

        
        return $this->render('classement/listClassement.html.twig', ['classements'=>$classements,
            'controller_name' => 'ClassementController',
        ]);
    }

}
