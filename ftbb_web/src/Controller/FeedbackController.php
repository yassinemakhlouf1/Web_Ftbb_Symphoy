<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Feedback;
use App\Form\FeedbackFormType;
use App\Form\ModifyFeedbackType;
use App\Form\ContactType;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Utils\Utilities;


class FeedbackController extends AbstractController
{
    /**
     * @Route("/feedback", name="feedback")
     */
    public function index(Request $req)
    {
        $fed = new Feedback();
        $form = $this ->createForm(FeedbackFormType::class,$fed); 
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $fed->setFeedbackId(Utilities::generateId($fed,"feedbackId",$this->getDoctrine()));
            $fed->setClientId("2943761");   
            $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"),"D M d, Y G:i");  
            $fed->setFeedbackDate($dateTime);
            $em->persist($fed);
            
            $em->flush();

            return $this->redirectToRoute("feedback_sent");
        }
        return $this->render('feedback/feedback.html.twig', [
            'feedback_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/feedback/show", name="feedback_show_client")
     */
    public function showFeedbacks()
    {
        $feedbacks = $this ->getDoctrine()->getRepository(Feedback :: class)->findAll(); //findAll trajjalik tableau lkoll
       
        return $this->render('feedback/clientshowfeedbacks.html.twig', ['feedbacks' => $feedbacks]);
        
    }

    /**
     * @Route("/feedback/supp/{id}", name="feedback_delete_client")
     */

    public function DeleteFeedbacks($id)
    {
        $feedback = new Feedback();
        /*$classe->setId($id);
        $classe->setName($name);*/

        $em = $this ->getDoctrine()->getManager();
        $feedback=$em->getRepository(Feedback::class)->find($id);
        $em->remove($feedback);
        $em->flush();

        //return $this->redirect('formulaire_ajout');
      
       
        return $this->redirectToRoute("feedback_show_client");
        
    }

     /**
     * @Route("/feedback/modify/{id}", name="feedback_modify_client")
     */
    public function modifyFeedbacks(Request $req,$id)
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $feedback = $entityManager->getRepository(Feedback::class)->find($id);
        $today = Utilities::getDateTimeObject(date("D M d, Y G:i"), "D M d, Y G:i");
        $diff=$feedback->getFeedbackDate()->diff($today);
        
        if($diff->format('%R%a')=="0"){
        $feedback = $entityManager->getRepository(Feedback::class)->find($id);
        $form = $this->createForm(ModifyFeedbackType::class, $feedback);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('feedback_show_client');
        }

        
        return $this->render('feedback/clientmodifyfeedback.html.twig', [
            'feedback_form' => $form->createView()
        ]);
        }else{
            return $this->render('feedback/feedbackExpired.html.twig', []);

        }
    }

    /**
     * @Route("/feedback/showAdmin", name="feedback_show_admin")
     */
    public function showReportsAdmins()
    {
        $feedbacks = $this ->getDoctrine()->getRepository(Feedback :: class)->findAll(); //findAll trajjalik tableau lkoll
       
        return $this->render('back/feedbackShowAdmin.html.twig', ['feedbacks' => $feedbacks]);
        
    }


    /**
     * @Route("/feedback/respond/{id}", name="feedback_respond")
     */
    public function RespondReport(Request $request,$id,\Swift_Mailer $mailer)
    {
        $feedback = $this->getDoctrine()->getRepository(Feedback::class)->find($id);
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
     * @Route("/feedback/sent", name="feedback_sent")
     */
    public function feedbackSent()
    {
        return $this->render('feedback/feedback-sent-sucess.html.twig',[]);
        
    }




}
