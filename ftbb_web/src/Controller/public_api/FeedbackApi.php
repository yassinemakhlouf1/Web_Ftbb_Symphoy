<?php

namespace App\Controller\public_api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Feedback;
use App\Form\FeedbackFormType;
use App\Form\ModifyFeedbackType;
use App\Form\ContactType;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Utils\Utilities;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Response;


class FeedbackApi extends AbstractController
{
    /**
     * @Route("/feedbackapi", name="feedbackapi")
     */
    public function index(Request $req,NormalizerInterface $normalizer)
    {
        $fed = new Feedback();
        $form = $this ->createForm(FeedbackFormType::class,$fed); 
        $form->handleRequest($req);
        
            $em = $this->getDoctrine()->getManager();
            $fed->setFeedbackId(Utilities::generateId($fed,"feedbackId",$this->getDoctrine()));
            $fed->setClientId("2943761");   
            $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"),"D M d, Y G:i");  
            $fed->setFeedbackDate($dateTime);

            $fed->setEmail($req->get("email"));
            $fed->setTopic($req->get("topic"));
            $fed->setType($req->get("type"));
            $fed->setText($req->get("text"));
            $em->persist($fed);
            
            $em->flush();
            

            
    

        
        $json = $normalizer->normalize($fed, 'json', ['groups' => 'feedback']);
        return new Response(json_encode($json)); 
    }

    /**
     * @Route("/feedbackapi/show", name="feedbackapi_show_client")
     */
    public function showFeedbacks(NormalizerInterface $normalizer)
    {
        $feedbacks = $this ->getDoctrine()->getRepository(Feedback :: class)->findAll(); //findAll trajjalik tableau lkoll
        $json = $normalizer->normalize($feedbacks, 'json', ['groups' => 'feedback']);
        return new Response(json_encode($json)); 



    }

    /**
     * @Route("/feedbackapi/supp/{id}", name="feedbackapi_delete_client")
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

        return new Response();  
        
    }

     /**
     * @Route("/feedbackapi/modify/{id}", name="feedbackapi_modify_client")
     */
    public function modifyFeedbacks(Request $req,$id,NormalizerInterface $normalizer)
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $feedback = $entityManager->getRepository(Feedback::class)->find($id);
        $today = Utilities::getDateTimeObject(date("D M d, Y G:i"), "D M d, Y G:i");
        $diff=$feedback->getFeedbackDate()->diff($today);
        
        if($diff->format('%R%a')=="0"){
        $feedback = $entityManager->getRepository(Feedback::class)->find($id);
        $form = $this->createForm(ModifyFeedbackType::class, $feedback);
        $form->handleRequest($req);

        return new Response(json_encode([["v" => "valid"]]));
        
        }else{
            return new Response(json_encode([["v" => "notvalid"]]));

        }
        $json = $normalizer->normalize($feedback, 'json', ['groups' => 'feedback']);
        return new Response(json_encode($json));
    }
     /**
     * @Route("/feedbackapi/modifynow/{id}", name="feedbackapi_modifynow_client")
     */
    public function modnow(Request $req,$id,NormalizerInterface $normalizer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reep= $entityManager->getRepository(Feedback::class)->find($id);
        $rep = $reep;
        $entityManager->remove($reep);
        $entityManager->flush();

        
        $rep->setText($req->get("text"));
        $entityManager->persist($rep);
        $entityManager->flush();

        $json = $normalizer->normalize($rep, 'json', ['groups' => 'feedback']);
        return new Response(json_encode($json));        

    }




    /**
     * @Route("/feedbackapi/showAdmin", name="feedbackapi_show_admin")
     */
    public function showReportsAdmins(NormalizerInterface $normalizer)
    {
        $feedbacks = $this ->getDoctrine()->getRepository(Feedback :: class)->findAll(); //findAll trajjalik tableau lkoll
       
        $json = $normalizer->normalize($feedbacks, 'json', ['groups' => 'feedback']);
        return new Response(json_encode($json));
    }


    /**
     * @Route("/feedbackapi/respond/{id}", name="feedbackapi_respond")
     */
    public function RespondReport(Request $request,$id,\Swift_Mailer $mailer,NormalizerInterface $normalizer)
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
        $json = $normalizer->normalize($feedback, 'json', ['groups' => 'feedback']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/feedbackapi/sent", name="feedbackapi_sent")
     */
    public function feedbackSent()
    {
        return $this->render('feedback/feedback-sent-sucess.html.twig',[]);
        
    }




}
