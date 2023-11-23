<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Request;
use  App\Entity\Classement;

class PDFController extends AbstractController
{

    private $snappy;
public function __construct(Pdf $snappy)
{
    $this->snappy = $snappy;
}
    /**
     * @Route("/p/d/f", name="p_d_f")
     */
    public function index(): Response
    {
        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PDFController',
        ]);
    }

        /**
     * @Route("/ExportPDFClassement/{id}", name="ExportPDFClassement")
     */
    public function ExportPDFClassement(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $classement = $entityManager->getRepository(Classement::class)->findBy(['idCompetition' => $id]);

        $html = $this->renderView('pdf/file.html.twig',['classement'=>$classement]);
         //Generate pdf with the retrieved HTML
         return new Response( $this->snappy->getOutputFromHtml($html), 200, array(
             'Content-Type'          => 'application/pdf',
             'Content-Disposition'   => 'inline; filename="export.pdf"'
          )
         );
    }
}
