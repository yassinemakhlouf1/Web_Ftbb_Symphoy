<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use  App\Entity\Competition;
use  App\Entity\Classement;
use  App\Entity\classF;
use  App\Entity\Game;
use App\Entity\Phase;
use App\Entity\Week;
use App\Entity\GameF; 

class APIController extends AbstractController
{
    
    /**
     * @Route("/api/", name="api")
     */
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'APIController',
        ]);
    }

    /**
 * @Route("/api/showCompetition", name="liste")
 */
    public function showCalendar()
{
    $repository = $this->getDoctrine()->getRepository(Competition::class);


    $classements = $repository->findAll();

    // On récupère la liste des articles

    // On spécifie qu'on utilise l'encodeur JSON
    $encoders = [new JsonEncoder()];

    // On instancie le "normaliseur" pour convertir la collection en tableau
    $normalizers = [new ObjectNormalizer()];

    // On instancie le convertisseur
    $serializer = new Serializer($normalizers, $encoders);

    // On convertit en json
    $jsonContent = $serializer->serialize($classements, 'json', [
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        }
    ]);

    // On instancie la réponse
    $response = new Response($jsonContent);

    // On ajoute l'entête HTTP
    $response->headers->set('Content-Type', 'application/json');

    // On envoie la réponse
    return $response;
}

    /**
 * @Route("/api/addCompetition/{name}/{image}", name="addCompetition")
 */
public function AddedCompetition(Request $request , $name , $image )
{
       $em = $this->getDoctrine()->getManager();
       $parameters = json_decode($request->getContent(), true);
        $Competition = new Competition();
        $Competition->setName($name);
        $Competition->setCalendar(null);

        $em->persist($Competition);
        $em->flush();

        // On spécifie qu'on utilise l'encodeur JSON
    $encoders = [new JsonEncoder()];

    // On instancie le "normaliseur" pour convertir la collection en tableau
    $normalizers = [new ObjectNormalizer()];

    // On instancie le convertisseur
    $serializer = new Serializer($normalizers, $encoders);

    // On convertit en json
    $jsonContent = $serializer->serialize($Competition, 'json');  

       // On instancie la réponse
       $response = new Response($jsonContent);

       // On ajoute l'entête HTTP
       $response->headers->set('Content-Type', 'application/json');
   
       // On envoie la réponse
       return $response;
}


/**
 * @Route("/api/showClassement/{id_competition}/{id_phase}", name="showClassement")
 */
public function showClassement(Request $request,$id_competition,$id_phase): Response
{   
    $Classement = $this->getDoctrine()->getRepository(Classement::class);
    $Classements= $Classement->findBy(['idCompetition' => $id_competition,'idPhase' => $id_phase]);

    $list = [] ;

     foreach ( $Classements as  $r) 
    {
        $rankpoule = new classF();
       
        $rankpoule->nameEquipe = $r->getIdTeam()->getName() ; 
        $rankpoule->logoEquipe  =  $r->getIdTeam()->getLogo() ; 
        $rankpoule->nb_pts   =  $r->getNbrPts(); 
        $rankpoule->competition_name = $r->getIdCompetition()->getName();
        $rankpoule->poule_name   =  $r->getIdPhase()->getName() ; 
        $rankpoule->nb_match   =  $r->getNbrPtsP(); 
        $rankpoule->match_g   =  $r->getNbrPtsG() ; 
        $rankpoule->match_d   =  $r->getNbrPtsD() ; 
        $rankpoule->diff       = $r->getPtsDiff() ; 
        
        $list[]=  $rankpoule ;
    } 
 
    // On récupère la liste des articles

    // On spécifie qu'on utilise l'encodeur JSON
    $encoders = [new JsonEncoder()];

    // On instancie le "normaliseur" pour convertir la collection en tableau
    $normalizers = [new ObjectNormalizer()];

    // On instancie le convertisseur
    $serializer = new Serializer($normalizers, $encoders);

    // On convertit en json
    $jsonContent = $serializer->serialize($list, 'json', [
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        }
    ]);

    // On instancie la réponse
    $response = new Response($jsonContent);

    // On ajoute l'entête HTTP
    $response->headers->set('Content-Type', 'application/json');

    // On envoie la réponse
    return $response;
}

 /**
 * @Route("/api/showGame/{id_competition}/{id_phase}/{id_week}", name="showGame")
 */
public function ShowgameUp(Request $request,$id_competition,$id_phase,$id_week): Response
{
  
    $games = $this->getDoctrine()->getRepository(Game::class);
    $game= $games->findBy(['idCompetition' => $id_competition,'idPhase' => $id_phase,'idWeek' => $id_week,]);


    $list = [] ;

    foreach ( $game as  $g) 
   {
       $games = new GameF();
        $games->id = $g->getId();
       $games->nameHome = $g->getIdTeamHome()->getName() ; 
       $games->logoHome  =  $g->getIdTeamHome()->getLogo() ; 
       $games->scoreHome   =  $g->getScoreHome();

       $games->nameAway = $g->getIdTeamAway()->getName();
       $games->logoAway   =  $g->getIdTeamAway()->getLogo() ; 
       $games->scoreAway   =  $g->getScoreAway(); 

       $games->status   =  $g->getStatus() ; 
       $games->salle   =  $g->getSalle() ; 
       $games->time       = $g->getTime() ; 
       
       $list[]=  $games ;
   } 

    return $this->json($list);
}

 /**
 * @Route("/api/showPhase", name="showPhase")
 */
public function showPhase()
{
    $repository = $this->getDoctrine()->getRepository(Phase::class);


    $phase = $repository->findAll();

    // On récupère la liste des articles

    // On spécifie qu'on utilise l'encodeur JSON
    $encoders = [new JsonEncoder()];

    // On instancie le "normaliseur" pour convertir la collection en tableau
    $normalizers = [new ObjectNormalizer()];

    // On instancie le convertisseur
    $serializer = new Serializer($normalizers, $encoders);

    // On convertit en json
    $jsonContent = $serializer->serialize($phase, 'json', [
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        }
    ]);

    // On instancie la réponse
    $response = new Response($jsonContent);

    // On ajoute l'entête HTTP
    $response->headers->set('Content-Type', 'application/json');

    // On envoie la réponse
    return $response;
}




 /**
 * @Route("/api/showWeeks", name="showWeeks")
 */
public function showWeeks()
{
    $repository = $this->getDoctrine()->getRepository(Week::class);


    $weeks = $repository->findAll();

  

    // On récupère la liste des articles

    // On spécifie qu'on utilise l'encodeur JSON
    $encoders = [new JsonEncoder()];

    // On instancie le "normaliseur" pour convertir la collection en tableau
    $normalizers = [new ObjectNormalizer()];

    // On instancie le convertisseur
    $serializer = new Serializer($normalizers, $encoders);

    // On convertit en json
    $jsonContent = $serializer->serialize($weeks, 'json', [
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        }
    ]);

    // On instancie la réponse
    $response = new Response($jsonContent);

    // On ajoute l'entête HTTP
    $response->headers->set('Content-Type', 'application/json');

    // On envoie la réponse
    return $response;
}
}