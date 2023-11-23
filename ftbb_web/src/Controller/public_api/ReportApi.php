<?php

namespace App\Controller\public_api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Report;
use App\Form\ReportFormType;
use App\Form\ModifyReportType;
use App\Form\ContactType;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Utils\Utilities;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class ReportApi extends AbstractController
{
    /**
     * @Route("/reportapi", name="reportapi")
     */
    public function index(Request $req,NormalizerInterface $normalizer)
    {
        $rep = new Report();
        $form = $this ->createForm(ReportFormType::class,$rep); 
        $form->handleRequest($req);
        
            $em = $this->getDoctrine()->getManager();
            $rep->setReportId(Utilities::generateId($rep,"reportId",$this->getDoctrine()));
            $rep->setClientId("2943763");
            $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"),"D M d, Y G:i");             
            $rep->setReportDate($dateTime);
            $rep->setCommandId($req->get("commandId"));
            $rep->setEmail($req->get("email"));
            $rep->setDescription($req->get("description"));
            $em->persist($rep);
            $em->flush();

        $json = $normalizer->normalize($rep, 'json', ['groups' => 'report']);

        return new Response(json_encode($json));        
 

    }

    /**
     * @Route("/reportapi/show", name="reportapi_show_client")
     */
    public function showReports(NormalizerInterface $normalizer)
    {
        $reports = $this ->getDoctrine()->getRepository(Report :: class)->findAll(); //findAll trajjalik tableau lkoll
        $json = $normalizer->normalize($reports, 'json', ['groups' => 'report']);

        return new Response(json_encode($json));        
    }

    /**
     * @Route("/reportapi/supp/{id}", name="reportapi_delete_client")
     */

    public function DeleteReports($id)
    {
        $report = new Report();
        /*$classe->setId($id);
        $classe->setName($name);*/

        $em = $this ->getDoctrine()->getManager();
        $report=$em->getRepository(Report::class)->find($id);
        $em->remove($report);
        $em->flush();

        //return $this->redirect('formulaire_ajout');

       
        //return $this->redirectToRoute("report_show_client");
        return new Response();        

    }

    /**
     * @Route("/reportapi/modify/{id}", name="reportapi_modify_client")
     */
    public function modifyReports(Request $req,$id,NormalizerInterface $normalizer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $rep= $entityManager ->getRepository(Report::class)->find($id);
        $today = Utilities::getDateTimeObject(date("D M d, Y G:i"), "D M d, Y G:i");
        $diff=$rep->getReportDate()->diff($today); 
        //var_dump($diff->format('%R%a days'));
        
        if($diff->format('%R%a')=="0"){
        
            $report = $entityManager->getRepository(Report::class)->find($id);
            $form = $this->createForm(ModifyReportType::class, $report);
            $form->handleRequest($req);
        
            


            return new Response(json_encode([["v" => "valid"]]));
        }else{
            return new Response(json_encode([["v" => "notvalid"]]));     
        }

        $json = $normalizer->normalize($rep, 'json', ['groups' => 'report']);
        return new Response(json_encode($json));        

    }
    /**
     * @Route("/reportapi/modifynow/{id}", name="reportapi_modifynow_client")
     */
    public function modnow(Request $req,$id,NormalizerInterface $normalizer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reep= $entityManager->getRepository(Report::class)->find($id);
        $rep = $reep;
        $entityManager->remove($reep);
        $entityManager->flush();

        $rep->setCommandId($req->get("cmd"));
        $rep->setEmail($req->get("email"));
        $rep->setDescription($req->get("dsc"));
        $entityManager->persist($rep);
        $entityManager->flush();

        $json = $normalizer->normalize($rep, 'json', ['groups' => 'report']);
        return new Response(json_encode($json));        

    }
    /**
     * @Route("/reportapi/showAdmin", name="reportapi_show_admin")
     */
    public function showReportsAdmins(NormalizerInterface $normalizer)
    {
        $reports = $this ->getDoctrine()->getRepository(Report :: class)->findAll(); //findAll trajjalik tableau lkoll
       
        //return $this->render('back/reportShowAdmin.html.twig', ['reports' => $reports]);
        $json = $normalizer->normalize($reports, 'json', ['groups' => 'report']);
        return new Response(json_encode($json));
    }

     /**
     * @Route("/reportapi/respond/{id}", name="reportapi_respond")
     */
    public function RespondReport(Request $request,$id,\Swift_Mailer $mailer,NormalizerInterface $normalizer)
    {
        $report = $this->getDoctrine()->getRepository(Report::class)->find($id);
        $form = $this->createForm(ContactType::class);
        $form ->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $contact = $form->getData();

            $message = (new \Swift_Message('We Responded to your Report !'))
            ->setFrom('ftbb.store@gmail.com')
            ->setTo($contact['email'])
            
            ->setBody($this->renderView('contact/contact.html.twig',compact('contact')),'text/html');

            $mailer->send($message);
            $this->addFlash('message','Le message a bien été envoyé ');
            

        }
        
        return $this->render('back/respondClient.html.twig',['id'=>$id,
            'contact_form' => $form->createView()
        ]);
        $json = $normalizer->normalize($report, 'json', ['groups' => 'report']);
        return new Response(json_encode($json));
    }

     /**
     * @Route("/reportapi/sent", name="reportapi_sent")
     */
    public function reportSent()
    {
        return $this->render('report/report-sent-success.html.twig',[]);
        
    }
    
}
