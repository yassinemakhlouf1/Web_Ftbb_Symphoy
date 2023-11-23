<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use  App\Entity\Team;
use  App\Entity\Classement;
use  App\Entity\Competition;
use  App\Entity\Statistique;
use  App\Entity\Game;
use  App\Entity\Week;
use  App\Entity\Phase;

class GameController extends AbstractController
{
     /**
     * @Route("/Addgame/{id_competition}/{id_phase}/{id_week}", name="Addgame")
     * @param $request
     * @return \symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request,$id_competition,$id_phase,$id_week): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $teams = $entityManager->getRepository(Team::class)->findBy(['idCompetition' => $id_competition]);

        
        return $this->render('game/add.html.twig', ['teams'=>$teams,'id_competition'=>$id_competition,'id_phase'=>$id_phase,'id_week'=>$id_week,
            'controller_name' => 'GameController',
        ]);
    }

 /**
     * @Route("/Addgame", name="Addgames")
     * @param $request
     * @return \symfony\Component\HttpFoundation\Response
     */
 
    public function Addgame(Request $request ,\Swift_Mailer $mailer)
    {
        
       $game=new Game();
       $entityManager = $this->getDoctrine()->getManager();

    if ($request->isMethod('POST')){
     $salle= $request->get('salle');
     $time= new \DateTime($request->get('time'));
      
     $id_competition= $request->get('id_competition');
     $competition = $entityManager->getRepository(Competition::class)->find($id_competition);
      $id_phase= $request->get('id_phase');
      $phase = $entityManager->getRepository(Phase::class)->find($id_phase);
      $id_week= $request->get('id_week');
      $week = $entityManager->getRepository(Week::class)->find($id_week);
      $id_team_h= $request->get('id_team_home');
      $team_H = $entityManager->getRepository(Team::class)->find($id_team_h);
      $id_team_a= $request->get('id_team_away');
      $team_A = $entityManager->getRepository(Team::class)->find($id_team_a);
       $statistique = $entityManager->getRepository(Statistique::class)->find(1);

       $repository = $this->getDoctrine()->getRepository(Classement::class);
       $classements = $repository->findAll();
       if (count($classements)===0){
        $classement1= new classement();
             $classement1->setIdCompetition($competition);
             $classement1->setIdPhase($phase);
             $classement1->setIdTeam($team_H);

             $classement1->setNbrPts(0);
             $classement1->setNbrPtsD(0);
             $classement1->setNbrPtsG(0);
             $classement1->setNbrPtsP(0);
             $classement1->setPtsDiff(0);
             

            

             $em=$this->getDoctrine()->getManager();
             $em->persist($classement1);
              $em->flush(); 

             $classement2= new classement();
             $classement2->setIdCompetition($competition);
             $classement2->setIdPhase($phase);
             $classement2->setIdTeam($team_A);

             
             $classement2->setNbrPts(0);
             $classement2->setNbrPtsD(0);
             $classement2->setNbrPtsG(0);
             $classement2->setNbrPtsP(0);
             $classement2->setPtsDiff(0);
             $em->persist($classement2);
              $em->flush();
             
        
       }
       else {

        $entityManager = $this->getDoctrine()->getManager();
        $classementH = $entityManager->getRepository(Classement::class)->findBy(['idCompetition' => $id_competition,'idPhase'=>$id_phase,'idTeam'=>$id_team_h]);
        $classementA = $entityManager->getRepository(Classement::class)->findBy(['idCompetition' => $id_competition,'idPhase'=>$id_phase,'idTeam'=>$id_team_a]);
       // return $this->json(count($classementH));

            if(count($classementH)!=0){

                if ( ($id_team_h!=$classementH[0]->getIdTeam()->getId()) ) {
           
                    $classement= new classement();

                     $classement->setIdCompetition($competition);
                     $classement->setIdPhase($phase);
                     $classement->setIdTeam($team_H);
                     
                        $classement->setNbrPts(0);
                        $classement->setNbrPtsD(0);
                        $classement->setNbrPtsG(0);
                        $classement->setNbrPtsP(0);
                        $classement->setPtsDiff(0);

                     $em=$this->getDoctrine()->getManager();
                    $em->persist($classement);
                     $em->flush();
                            
                           
                 } 
            }
            else {
                    $classement= new classement();
                     $classement->setIdCompetition($competition);
                     $classement->setIdPhase($phase);
                     $classement->setIdTeam($team_H);

                     $classement->setNbrPts(0);
                     $classement->setNbrPtsD(0);
                     $classement->setNbrPtsG(0);
                     $classement->setNbrPtsP(0);
                     $classement->setPtsDiff(0);

                     $em=$this->getDoctrine()->getManager();
                    $em->persist($classement);
                     $em->flush();
            }
 
            // return $this->json(count($classementH));

            if(count($classementA)!=0){

                if ( ($id_team_a!=$classementA[0]->getIdTeam()->getId()) ) {
           
                    $classement= new classement();
                     $classement->setIdCompetition($competition);
                     $classement->setIdPhase($phase);
                     $classement->setIdTeam($team_A);

                     $classement->setNbrPts(0);
                     $classement->setNbrPtsD(0);
                     $classement->setNbrPtsG(0);
                     $classement->setNbrPtsP(0);
                     $classement->setPtsDiff(0);

                     $em=$this->getDoctrine()->getManager();
                    $em->persist($classement);
                     $em->flush();
                            
                           
                 } 
            }
            else {
                $classement= new classement();
                     $classement->setIdCompetition($competition);
                     $classement->setIdPhase($phase);
                     $classement->setIdTeam($team_A);
                     $classement->setNbrPts(0);
                     $classement->setNbrPtsD(0);
                     $classement->setNbrPtsG(0);
                     $classement->setNbrPtsP(0);
                     $classement->setPtsDiff(0);


                     $em=$this->getDoctrine()->getManager();
                    $em->persist($classement);
                     $em->flush();
            }
 
   
       }
       
       
      $game->setStatus(0);
      $game->setScoreHome(0);
      $game->setScoreAway(0);
      $game->setIdStatistique($statistique);
      $game->setIdTeamHome($team_H);
      $game->setIdTeamAway($team_A);
      $game->setIdCompetition($competition);
      $game->setIdPhase($phase);
      $game->setIdWeek($week);
      $game->setSalle($salle);
       $game->setTime($time); 
      

     
       $message = (new \Swift_Message('Match Adedd  !'))
       ->setFrom('ftbb.store@gmail.com')
       ->setTo('habib.chaabene@esprit.tn')
       
       ->setBody($this->renderView('contact/gameContact.html.twig',['game'=>$game]),'text/html');

       $mailer->send($message);

      $em=$this->getDoctrine()->getManager();
    $em->persist($game);
    $em->flush(); 
      return $this->redirectToRoute('Showgames');   
  


    }            

    

    
}




/**
     * @Route("/Showgames", name="Showgames")
     */
    public function Showgame(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Game::class);
        $games = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(Competition::class);
        $competitions = $repository->findAll();
        $repository = $this->getDoctrine()->getRepository(Phase::class);
        $phases = $repository->findAll();
        $repository = $this->getDoctrine()->getRepository(Week::class);
        $weeks = $repository->findAll();

        
        return $this->render('game/listGame.html.twig', ['games'=>$games,'competitions'=>$competitions,'phases'=>$phases,'weeks'=>$weeks,
            'controller_name' => 'GameController',
        ]);
    }


/**
     * @Route("/ShowgamesUp", name="ShowgamesUp")
     
     */
    public function ShowgameUp(Request $request)
    {
        $competition_id = $request->get('competition_id');
        $id_phase = $request->get('id_phase');
        $id_week = $request->get('id_week');
        $games = $this->getDoctrine()->getRepository(Game::class);
        $game= $games->findBy(['idCompetition' => $competition_id,'idPhase' => $id_phase,'idWeek' => $id_week,]);
  

        return $this->json($game);
        
    }



/**
     * @Route("/navAddGame", name="navAddGame")
     
     */
    public function navAddGame(Request $request)
    {
        $competition_id = $request->get('competition_id');
        $id_phase = $request->get('id_phase');
        $id_week = $request->get('id_week');
        $cc = array();
        array_push($cc,$competition_id); 
        array_push($cc,$id_phase); 
        array_push($cc,$id_week); 
        return $this->json($cc);
      
        
    }










/**
     * @Route("/score/edit/{id}", name="score_edit")
     */
    public function score_edit(Request $request,int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $game = $entityManager->getRepository(Game::class)->find($id);
        
        return $this->render('game/Score_edit.html.twig', ['game'=>$game,
        'controller_name' => 'TeamController',
    ]);
    }

/**
     * @Route("/score/update/{id}", name="score_update")
     */
    public function update(Request $request, $id): Response
    {
         $entityManager = $this->getDoctrine()->getManager();
        $game = $entityManager->getRepository(Game::class)->find($id);

        if (!$game) {
            throw $this->createNotFoundException(
                'No team found for id '.$id
            );
        }
        $game->setScoreHome($request->get('scoreHome'));
        $game->setScoreAway($request->get('scoreAway'));
        $game->setStatus(1);
        $classementH = $entityManager->getRepository(Classement::class)->findBy(['idCompetition' => $game->getIdCompetition()->getId(),'idPhase'=>$game->getIdPhase()->getId(),'idTeam'=>$game->getIdTeamHome()->getId()]);
        $classementA = $entityManager->getRepository(Classement::class)->findBy(['idCompetition' => $game->getIdCompetition()->getId(),'idPhase'=>$game->getIdPhase()->getId(),'idTeam'=>$game->getIdTeamAway()->getId()]);
        if ($request->get('scoreHome') > $request->get('scoreAway')){
            
            $classementH[0]->setNbrPts($classementH[0]->getNbrPts()+2);
            $classementA[0]->setNbrPts($classementA[0]->getNbrPts()+1);

            $classementH[0]->setNbrPtsP($classementH[0]->getNbrPtsP()+1);
            $classementA[0]->setNbrPtsP($classementA[0]->getNbrPtsP()+1);

            $classementH[0]->setNbrPtsG($classementH[0]->getNbrPtsG()+1);
            $classementA[0]->setNbrPtsD($classementA[0]->getNbrPtsD()+1);

            $classementH[0]->setPtsDiff($classementH[0]->getPtsDiff()+ ($request->get('scoreHome')-$request->get('scoreAway')) );
            $classementA[0]->setPtsDiff($classementA[0]->getPtsDiff()- ($request->get('scoreHome')-$request->get('scoreAway')) );
        }
        elseif ($request->get('scoreHome') < $request->get('scoreAway')){
            $classementH[0]->setNbrPts($classementH[0]->getNbrPts()+1);
            $classementA[0]->setNbrPts($classementA[0]->getNbrPts()+2);

            $classementH[0]->setNbrPtsP($classementH[0]->getNbrPtsP()+1);
            $classementA[0]->setNbrPtsP($classementA[0]->getNbrPtsP()+1);

            $classementA[0]->setNbrPtsG($classementA[0]->getNbrPtsG()+1);
            $classementH[0]->setNbrPtsD($classementH[0]->getNbrPtsD()+1);

            $classementA[0]->setPtsDiff($classementA[0]->getPtsDiff()+ ($request->get('scoreHome')-$request->get('scoreAway')) );
            $classementH[0]->setPtsDiff($classementH[0]->getPtsDiff()- ($request->get('scoreHome')-$request->get('scoreAway')) );
        }        
        $entityManager->flush();
 



        

        return $this->redirectToRoute('Showgames');
    }

}