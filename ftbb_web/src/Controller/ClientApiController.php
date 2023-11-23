<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\User;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
/**
 * @Route("/client/api")
 */
class ClientApiController extends AbstractController
{
    /**
     * @Route("/", name="client_api")
     */
    public function index(): Response
    {
        return $this->render('client_api/index.html.twig', [
            'controller_name' => 'ClientApiController',
        ]);
    }

    /**
     * @Route("/get/{email}", name="getclient")
     */
    public function getClient($email){
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository(Client::class)->findOneBy(['email'=>$email]);
        if($client){
            return new Response(json_encode([["id" => $client->getId()],["name"=>$client->getName()]]));
        }

    }
    /**
     * @Route("/signup", name="appregister")
     */
    public function  signupAction(Request  $request, UserPasswordEncoderInterface $passwordEncoder) {

        $email = $request->query->get("email");
        $name = $request->query->get("name");
        $surname = $request->query->get("surname");
        $number = $request->query->get("number");
        $birthday = $request->query->get("birthday");
        $sex = $request->query->get("sex");
        $password = $request->query->get("password");
//        $roles= $request->query->get("roles");


        //control al email lazm @
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new Response("email invalid.");
        }
        $client = new Client ();
        $client->setSurname($surname);
        $client->setname($name);
        $client->setEmail($email);
        $client->setBirthday(new \DateTime($birthday));
        $client->setNumber($number);
        $client->setSex($sex);
        $client->setCreationDate(new \DateTime());
        $client->setStatus(0);


        $pass = $passwordEncoder->encodePassword(
            $client,
            $password
        );
        $client->setPassword($pass);
        $client->setIsVerified(true);//par défaut user lazm ykoun enabled.



        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            return new JsonResponse("success",200);//200 ya3ni http result ta3 server OK
        }catch (\Exception $ex) {
            return new Response("execption ".$ex->getMessage());
        }
    }


    /**
     * @Route("/signin", name="applogin")
     */

    public function signinAction(Request $request) {
        $email = $request->query->get("email");
        $password = $request->query->get("password");

        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository(Client::class)->findOneBy(['email'=>$email]);//bch nlawj ala user b username ta3o fi base s'il existe njibo
        //ken l9ito f base
        if($client){
            //lazm n9arn password zeda madamo crypté nesta3mlo password_verify
            if(password_verify($password,$client->getPassword())) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($client);
                return new JsonResponse($formatted);
            }
            else {
                return new Response("passowrd not found");
            }
        }
        else {
            return new Response("failed");//ya3ni username/pass mch s7a7

        }
    }


    /**
     * @Route("/ediUser", name="app_gestion_profile")
     */

    public function editClient(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $id = $request->get("id");//kima query->get wala get directement c la meme chose
        $name = $request->query->get("name");
        $surname = $request->query->get("surname");
        $number = $request->query->get("number");
        $birthday = $request->query->get("birthday");
        $sex = $request->query->get("sex");
        $password = $request->query->get("password");
        $email = $request->query->get("email");
        $em=$this->getDoctrine()->getManager();
        $client = $em->getRepository(Client::class)->find($id);
        //bon l modification bch na3mlouha bel image ya3ni kif tbadl profile ta3ik tzid image
        if($request->files->get("photo")!= null) {

            $file = $request->files->get("photo");//njib image fi url
            $fileName = $file->getClientOriginalName();//nom ta3ha

            //taw na5ouha w n7otaha fi dossier upload ely tet7t fih les images en principe te7t public folder
            $file->move(
                $fileName
            );
            $client->setPhotoUrl($fileName);
        }

        $client->setSurname($surname);
        $client->setname($name);
        $client->setBirthday(new \DateTime($birthday));
        $client->setNumber($number);
        $client->setSex($sex);
        $client->setCreationDate(new \DateTime());
        $client->setStatus(0);
        $client->setPassword(
            $passwordEncoder->encodePassword(
                $client,
                $password
            )
        );

        $client->setEmail($email);
        $client->setIsVerified(true);//par défaut user lazm ykoun enabled.



        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            return new JsonResponse("success",200);//200 ya3ni http result ta3 server OK
        }catch (\Exception $ex) {
            return new Response("fail ".$ex->getMessage());
        }}
}