<?php

namespace App\Controller\public_api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Galerie;
use App\Form\GalerieFormType;
use App\Form\ModifyGalerieType;
use App\Utils\Utilities;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Response;


class GalerieApi extends AbstractController
{
    /**
     * @Route("/galerieapi", name="galerieapi")
     */
    public function index(Request $req,NormalizerInterface $normalizer)
    {
        $gal = new Galerie();
        $form = $this ->createForm(GalerieFormType::class,$gal); 
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
             /*** @var UploadedFile $uploadedFile */
             $uploadedFile = $form['url']->getData();
             $destination = $this->getParameter('kernel.project_dir').'/public/images/galerie';
 
             $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
             $newFilename = '-'.uniqid().'.'.$uploadedFile->guessExtension();
             $uploadedFile->move(
                 $destination,
                 $newFilename
             );
             $gal->setPhotoUrl("http://127.0.0.1/ftbb_web/ftbb_web/public/images/galerie/".$newFilename);
            $em = $this->getDoctrine()->getManager();
            $gal->setGalerieId(Utilities::generateId($gal,"galerieId",$this->getDoctrine()));
            $gal->setAdminId("999");   
            $em->persist($gal);
            $em->flush();

            //return $this->redirect('list');
        }
        return $this->render('back/galleryAdd.html.twig', [
            'galerie_form' => $form->createView()
        ]);
        $json = $normalizer->normalize($gal, 'json', ['groups' => 'galerie']);
        return new Response(json_encode($json)); 
    }

    /**
     * @Route("/galerieapi/show", name="galerieapi_show_admin")
     */
    public function showGalerie(NormalizerInterface $normalizer)
    {
        $galeries = $this ->getDoctrine()->getRepository(Galerie :: class)->findAll(); //findAll trajjalik tableau lkoll
       
        $json = $normalizer->normalize($galeries, 'json', ['groups' => 'galerie']);
        return new Response(json_encode($json));
        
    }

    
    /**
     * @Route("/galerieapi/supp/{id}", name="galerieapi_delete_admin")
     */

    public function DeletePhoto($id,NormalizerInterface $normalizer)
    {
        $galerie = new Galerie();
        /*$classe->setId($id);
        $classe->setName($name);*/

        $em = $this ->getDoctrine()->getManager();
        $galerie=$em->getRepository(Galerie::class)->find($id);
        $em->remove($galerie);
        $em->flush();

        //return $this->redirect('formulaire_ajout');
        $json = $normalizer->normalize($galerie, 'json', ['groups' => 'galerie']);
        return new Response(json_encode($json));
       
        return $this->redirectToRoute("galerie_show_admin");
        
    }

       /**
     * @Route("/galerieapi/showclient", name="galerieapi_show_client")
     */
    public function showgalerieClient(NormalizerInterface $normalizer)
    {
        $galeries = $this ->getDoctrine()->getRepository(Galerie :: class)->findAll(); //findAll trajjalik tableau lkoll
        $json = $normalizer->normalize($galeries, 'json', ['groups' => 'galerie']);
        return new Response(json_encode($json));
       
        
    } 
    



}
