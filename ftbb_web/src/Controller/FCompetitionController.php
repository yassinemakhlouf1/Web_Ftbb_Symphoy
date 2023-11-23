<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use  App\Entity\Competition;
use  App\Entity\Game;
use  App\Entity\Classement;
use  App\Entity\Phase;
use  App\Entity\Week;

class FCompetitionController extends AbstractController
{
    /**
     * @Route("/f/competition", name="f_competition")
     */
    public function index(): Response
    {     $repository = $this->getDoctrine()->getRepository(Competition::class);
        $competitions = $repository->findAll(); 
        
        return $this->render('f_competition/index.html.twig', [   'comp'=>$competitions, 
            'controller_name' => 'FCompetitionController',
        ]);
    }
     /**
     * @Route("ShowCalendar/{id}", name="ShowCalendar")
     */
    public function ShowCalendar(Request $request, $id): Response
    {          
        $repository = $this->getDoctrine()->getRepository(Competition::class);
        $competitions = $repository->findAll(); 
        
        $repository = $this->getDoctrine()->getRepository(Phase::class);
        $phases = $repository->findAll();
        

        $entityManager = $this->getDoctrine()->getManager();

           $Game = $entityManager->getRepository(Game::class)->findBy(['idCompetition' => $id]);
         
           $repository = $this->getDoctrine()->getRepository(Week::class);
           $weeks = $repository->findAll();
        
        return $this->render('f_competition/ShowCalendar.html.twig', [   'competition_id'=>$id, 'comp'=>$competitions,  'weeks'=>$weeks,'phases'=>$phases,
            'controller_name' => 'FCompetitionController',
        ]);
    }

       /**
     * @Route("ShowClassementF/{id}", name="ShowClassementF")
     */
    public function ShowClassementF(Request $request, $id): Response
    {    
        $repository = $this->getDoctrine()->getRepository(Phase::class);
        $phases = $repository->findAll();
        
        $entityManager = $this->getDoctrine()->getManager();
        $classement = $entityManager->getRepository(Classement::class)->findBy(['idCompetition' => $id]);
        $repository = $this->getDoctrine()->getRepository(Competition::class);
        $competitions = $repository->findAll(); 
        

        return $this->render('f_competition/ShowClassementF.html.twig', [   'classement'=>$classement, 'comp'=>$competitions,'phases'=>$phases, 
            'controller_name' => 'FCompetitionController',
        ]);
    }

    
/**
     * @Route("/ShowClasementUp", name="ShowClasementUp")
     
     */
    public function ShowClasementUp(Request $request)
    {
        $competition_id = $request->get('competition_id');
        $id_phase = $request->get('id_phase');
       
        $classement = $this->getDoctrine()->getRepository(Classement::class);
        $classements= $classement->findBy(['idCompetition' => $competition_id,'idPhase' => $id_phase]);
  

        return $this->json($classements);
        
    }
}
