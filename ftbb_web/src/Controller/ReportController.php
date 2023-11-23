<?php

namespace App\Controller;

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


class ReportController extends AbstractController
{
    /**
     * @Route("/report", name="report")
     */
    public function index(Request $req)
    {
        $rep = new Report();
        $form = $this ->createForm(ReportFormType::class,$rep); 
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $rep->setReportId(Utilities::generateId($rep,"reportId",$this->getDoctrine()));
            $rep->setClientId(122);
            $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"),"D M d, Y G:i");             
            $rep->setReportDate($dateTime);
            $em->persist($rep);
            $em->flush();

            return $this->redirectToRoute("report_sent");
        }
        return $this->render('report/report.html.twig', [
            'report_form' => $form->createView()
        ]);

    }

    /**
     * @Route("/report/show", name="report_show_client")
     */
    public function showReports()
    {
        $reports = $this ->getDoctrine()->getRepository(Report :: class)->findBy(array('clientId'=>122));
       
        return $this->render('report/clientshowreport.html.twig', ['reports' => $reports]);
        
    }

    /**
     * @Route("/report/supp/{id}", name="report_delete_client")
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
      
       
        return $this->redirectToRoute("report_show_client");
        
    }

    /**
     * @Route("/report/modify/{id}", name="report_modify_client")
     */
    public function modifyReports(Request $req,$id)
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
        
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('report_show_client');
        }


        return $this->render('report/clientmodifyreport.html.twig', [
            'report_form' => $form->createView()
        ]);
        }else{
            return $this->render('report/reportExpired.html.twig', []);
        }
    }

    /**
     * @Route("/report/showAdmin", name="report_show_admin")
     */
    public function showReportsAdmins()
    {
        $reports = $this ->getDoctrine()->getRepository(Report :: class)->findAll(); //findAll trajjalik tableau lkoll
       
        return $this->render('back/reportShowAdmin.html.twig', ['reports' => $reports]);
        
    }

     /**
     * @Route("/report/respond/{id}", name="report_respond")
     */
    public function RespondReport(Request $request,$id,\Swift_Mailer $mailer)
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
        
    }

     /**
     * @Route("/report/sent", name="report_sent")
     */
    public function reportSent()
    {
        return $this->render('report/report-sent-success.html.twig',[]);
        
    }
    
}
