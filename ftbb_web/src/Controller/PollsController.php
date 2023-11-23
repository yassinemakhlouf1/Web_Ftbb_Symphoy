<?php

namespace App\Controller;

use App\Entity\Options;
use App\Entity\Poll;
use App\Form\OptionsType;
use App\Utils\Utilities;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PollType;
use App\Entity\Vote;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;

class PollsController extends AbstractController
{
// *********************************************Liste POLL*********************************************
    /**
     * @Route("/polllist", name="poll_list")
     */
    public function polllist(NormalizerInterface $normalizer)
    {
        $poll = $this->getDoctrine()->getRepository(Poll::class)->findBy(array(), array('creationDate' => 'DESC'));


        $data=$normalizer->normalize($poll, 'json',['groups'=>'post:read']);
        return new Response(json_encode($data));


    }


// *********************************************List Option*********************************************
    /**
     * @Route("/optionlist/{id}", name="option_list")
     */
    public function optionliste(NormalizerInterface $normalizer,Poll $id)
    {
        $option = $this->getDoctrine()->getRepository(Options::class)->findBy(['poll'=>$id]);


        $data=$normalizer->normalize($option, 'json',['groups'=>'post:read']);
        return new Response(json_encode($data));
    }

    // *********************************************List Vote*********************************************
    /**
     * @Route("/votelist/{ido}", name="vote_list")
     */
    public function voteliste(NormalizerInterface $normalizer, Options $ido)
    {
        $vote = $this->getDoctrine()->getRepository(Vote::class)->findBy(['option'=>$ido]);

        $data=$normalizer->normalize($vote, 'json',['groups'=>'post:read']);
        return new Response(json_encode($data));
    }


    // *********************************************Voting*********************************************
    /**
     * @Route("/vote/{optId}", name="vote")
     * * @Method ("POST")
     */
    public function vote($optId)
    {

        $vote = new Vote();

        $em = $this->getDoctrine()->getManager();
        //
        $vote=$em->getRepository(Vote::class)->findBy(['option'=>$optId]);
        foreach ($vote as $key => $value) {
            if($value->getOption()->getOptionId()==$optId)
                $vote=$this->getDoctrine()->getRepository(Vote::class)->find($value->getVoteId());
        }
        $vote->setVoteNbr($vote->getVoteNbr()+1);
        $em->flush();
;
        return new Response("done");
    }







//
//// *********************************************ADDPOLL*********************************************
//    /**
//     * @Route("/addpoll", name="add_poll")
//     * @Method ("POST")
//     */
//    public function addPoll (Request $request)
//    {
//        $poll = new Poll();
//
//        $despcription = $request->query->get("description");
//        $em = $this ->getDoctrine()->getManager();
//
//
//            $poll->setPollId(Utilities::generateId($poll,'pollId',$this ->getDoctrine()));
//            $poll->setDescription($despcription);
//            $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"),"D M d, Y G:i");
//            $poll->setCreationDate($dateTime);
//            $poll->setStatus("Active");
//
//            $em->persist($poll);
//            $em->flush();
//
//
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($poll);
//        return new JsonResponse($formatted);
//    }
//







//
//// *********************************************DELETE*********************************************
//    /**
//     * @Route("/deletepoll", name="delete_poll")
//     * @Method ("DELETE")
//     */
//    public function deletePoll(Request $request)
//    {
//        $pollId = $request->get('pollid');
//
//        $em = $this->getDoctrine()->getManager();
//        $poll = $em->getRepository(Poll::class)->find($pollId);
//        $em->remove($poll);
//        $em->flush();
//
//
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize("deleted succefully");
//        return new JsonResponse($formatted);
//    }
//
//// *********************************************END-POLL*********************************************
//
//    /**
//     * @Route("/endpoll", name="end_poll")
//     * @Method ("POST")
//     */
//    public function endPoll (Request $request)
//    {
//        $pollId = $request->get('pollid');
//
//
//        $em = $this->getDoctrine()->getManager();
//        $poll = $em->getRepository(Poll::class)->find($pollId);
//        $poll->setStatus('Ended');
//        $em->flush();
//
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($poll);
//        return new JsonResponse($formatted);
//    }

// *********************************************ADD-Option*********************************************
//    /**
//     * @Route("/addoption", name="add_option")
//     * @Method ("POST")
//     */
//    public function addoption (Request $request)
//    {
//        $option = new Options();
//
//        $despcription = $request->query->get("optdescription");
//        $em = $this ->getDoctrine()->getManager();
//
//        $option->setOptionId(Utilities::generateId($option,'optionId',$this ->getDoctrine()));
//        $option->setDescription($despcription);
//
//
//        $poll = $em->getRepository(Poll::class)->find($poll_id);
//        $option->setPoll($poll);
//
//        $em->persist($option);
//        $em->flush();
//
//        if($number==2) {
//            $vote = new Vote();
//            $em = $this ->getDoctrine()->getManager();
//            $vote->setVoteId(Utilities::generateId($vote,'voteId',$this ->getDoctrine()));
//            $vote -> setOption($option);
//
//            $em->persist($vote);
//            $em->flush();
//            $this->addFlash('success','Poll Added Succussfuly');
//            return $this->redirectToRoute('poll');
//        }else{
//            $vote = new Vote();
//            $em = $this ->getDoctrine()->getManager();
//            $vote->setVoteId(Utilities::generateId($vote,'voteId',$this ->getDoctrine()));
//            $vote -> setOption($option);
//
//            $em->persist($vote);
//            $em->flush();
//            return $this->redirectToRoute('add_option', ['poll_id'=>$poll->getPollId(),'number'=>2]);
//        }
//
//
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($poll);
//        return new JsonResponse($formatted);
//    }
}


