<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use  App\Entity\Team;
use  App\Entity\Competition;
class TeamController extends AbstractController
{
    /**
     * @Route("/team", name="team")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Competition::class);
        $competitions = $repository->findAll();

        return $this->render('team/add.html.twig', [ 'comp'=>$competitions ,
        'controller_name' => 'TeamController',
    ]);
    }

       /**
     * @Route("/Addteams", name="Addteams")
     * @param $request
     * @return \symfony\Component\HttpFoundation\Response
     */
    public function Addteams(Request $request)
    {
        
       $team=new Team();
       $entityManager = $this->getDoctrine()->getManager();

    if ($request->isMethod('POST')){
     $name= $request->get('name');
     $id_competition= $request->get('id_competition');
      $competition = $entityManager->getRepository(Competition::class)->find( $id_competition);
      

      $image=$request->files->get('image');

   
      $name_img = $this->generateUrlFromName() . '.' . $image->guessExtension();
       try {
          $image->move(
              $this->getParameter('image_directory'),
              $name_img
          );
      } catch (FileException $e) {
          
      } 

      

       $team->setName($name);
       $team->setLogo($name_img);
     $team->setIdCompetition($competition);

     
    $em=$this->getDoctrine()->getManager();
    $em->persist($team);
    $em->flush(); 
     return $this->redirectToRoute('Showteams'); 
    }
}

/**
     * @Route("/Showteams", name="Showteams")
     */
    public function Showteam(): Response
    {
        $repository = $this->getDoctrine()->getRepository(team::class);


        $teams = $repository->findAll();

        
        return $this->render('team/listTeam.html.twig', ['team'=>$teams,
            'controller_name' => 'TeamController',
        ]);
    }

/**
     * @Route("/team/delete/{id}", name="team_delete")
     */
    public function delete(Request $request,int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $team = $entityManager->getRepository(Team::class)->find($id);

        if (!$team) {
            throw $this->createNotFoundException(
                'No team found for id '.$id
            );
        }
        $entityManager->remove($team);
        $entityManager->flush();

        return $this->redirectToRoute('Showteams');
    }


/**
     * @Route("/team/edit/{id}", name="team_edit")
     */
    public function edit(Request $request,int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $team = $entityManager->getRepository(Team::class)->find($id);
        $repository = $this->getDoctrine()->getRepository(Competition::class);


        $competitions = $repository->findAll();
        return $this->render('team/edit.html.twig', ['team'=>$team,'comp'=>$competitions,
        'controller_name' => 'TeamController',
    ]);
    }
    /**
     * @Route("/team/update/{id}", name="team_update")
     */
    public function update(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $team = $entityManager->getRepository(Team::class)->find($id);

        if (!$team) {
            throw $this->createNotFoundException(
                'No team found for id '.$id
            );
        }

        $team->setName($request->get('name'));
        $comp = $entityManager->getRepository(Competition::class)->find($request->get('id_competition'));

        $team->setIdCompetition($comp );

        
        $entityManager->flush();

        return $this->redirectToRoute('Showteams');
    }



    public function generateUrlFromName()
    {
        return md5(uniqid());
    }
}
