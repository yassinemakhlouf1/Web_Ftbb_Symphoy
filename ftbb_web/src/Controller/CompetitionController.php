<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use  App\Entity\Competition;
class CompetitionController extends AbstractController
{
    /**
     * @Route("/competition", name="competition")
     */
    public function index(): Response
    {
        return $this->render('competition/index.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }

      /**
     * @Route("/Addcompetition", name="Addcompetition")
     * @param $request
     * @return \symfony\Component\HttpFoundation\Response
     */
    public function Addcompetition(Request $request)
    {
        
        $competition=new Competition();

if (($request->isMethod('POST'))){
    $name= $request->get('name');
    $competition->setName($name);
    $em=$this->getDoctrine()->getManager();
    $em->persist($competition);
    $em->flush();
    return $this->redirectToRoute('Showcompetition');
}


    }


    /**
     * @Route("/Showcompetition", name="Showcompetition")
     */
    public function Showcompetition(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Competition::class);


        $competitions = $repository->findAll();

        
        return $this->render('competition/listCompetition.html.twig', ['comp'=>$competitions,
            'controller_name' => 'CompetitionController',
        ]);
    }

      /**
     * @Route("/competition/delete/{id}", name="competition_delete")
     */
    public function delete(Request $request,int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $competition = $entityManager->getRepository(Competition::class)->find($id);

        if (!$competition) {
            throw $this->createNotFoundException(
                'No competition found for id '.$id
            );
        }
        $entityManager->remove($competition);
        $entityManager->flush();

        return $this->redirectToRoute('Showcompetition');
    }

 /**
     * @Route("/competition/edit/{id}", name="competition_edit")
     */
    public function edit(Request $request,int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $competition = $entityManager->getRepository(Competition::class)->find($id);

        return $this->render('competition/edit.html.twig', ['c'=>$competition,
        'controller_name' => 'CompetitionController',
    ]);
    }
    /**
     * @Route("/competition/update/{id}", name="competition_update")
     */
    public function update(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $competition = $entityManager->getRepository(Competition::class)->find($id);

        if (!$competition) {
            throw $this->createNotFoundException(
                'No competition found for id '.$id
            );
        }

        $competition->setName($request->get('name'));
        $entityManager->flush();

        return $this->redirectToRoute('Showcompetition');
    }

}
