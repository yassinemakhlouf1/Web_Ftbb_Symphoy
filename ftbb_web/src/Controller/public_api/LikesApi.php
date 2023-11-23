<?php

namespace App\Controller\public_api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;
use App\Entity\Article;
use App\Entity\Client;
use App\Entity\Likes;
use App\Utils\Utilities;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LikesApi extends AbstractController
{
    /**
     * @Route("/likes/comment/{comment_id}/{client_id}", name="comment_like_api");
     */
    public function onClickLike($client_id, $comment_id, NormalizerInterface $norm, \Swift_Mailer $mailer){
        $em = $this ->getDoctrine()->getManager();
        $like = $this ->getDoctrine()->getRepository(Likes :: class)->findBy(array('idClient'=>$client_id, 'idComment'=>$comment_id));
        if(!empty($like)){
            $em->remove($like[0]);
            $em->flush();
        }else{
            $like = new Likes();
            $client = $this ->getDoctrine()->getRepository(Client :: class)->find($client_id);
            $comment = $this ->getDoctrine()->getRepository(Comment :: class)->find($comment_id);

            $like->setIdLike(Utilities::generateId($like, "idLike", $this->getDoctrine()));
            $like->setIdClient($client);
            $like->setIdComment($comment);
            $em->persist($like);
            $em->flush();
            if($comment->getClient()->getId() != $client->getId()){
            $msg = (new \Swift_Message('[FTBB_SOCIAL] your comment got likes!'))
                ->setFrom("ftbb.store@gmail.com")
                ->setTo($comment->getClient()->getEmail())
                ->setBody($this->render('email/body.html.twig', ['name' => $comment->getClient()->getName(), 'comment' => $comment->getContent()]))
            ;
            $mailer->send($msg);

            $this->addFlash('message', 'Le message a bien été envoyé');
            }
        }
        return new Response(json_encode(""));
    }

    /**
     * @Route("/likes/article/{article_id}/{client_id}", name="article_like_api");
     */
    public function onClickLikeArticle(NormalizerInterface $norm, $article_id, $client_id){
        $em = $this ->getDoctrine()->getManager();
        $like = $this ->getDoctrine()->getRepository(Likes :: class)->findBy(array('idClient'=>$client_id, 'idArticle'=>$article_id));
        
        if(!empty($like)){
            $em->remove($like[0]);
            $em->flush();
        }else{
            $like = new Likes();
            $client = $this ->getDoctrine()->getRepository(Client :: class)->find($client_id);
            $article = $this ->getDoctrine()->getRepository(Article :: class)->find($article_id);

            $like->setIdLike(Utilities::generateId($like, "idLike", $this->getDoctrine()));
            $like->setIdClient($client);
            $like->setIdArticle($article);
            $em->persist($like);
            $em->flush();
        }
        return new Response(json_encode(""));
    }
    /**
     * @Route("/likes/check/article/{article_id}/{client_id}", name="check_article_like_api");
     */
    public function onClickLikeArticleChecker(NormalizerInterface $norm, $article_id, $client_id){
        $em = $this ->getDoctrine()->getManager();
        $like = $this ->getDoctrine()->getRepository(Likes :: class)->findBy(array('idClient'=>$client_id, 'idArticle'=>$article_id));
        if(empty($like)){
            return new Response(json_encode([["check" => "0"]]));
        }else{
            return new Response(json_encode([["check" => "1"]]));
        }
        return new Response(json_encode([["check" => "1"]]));
    }
    /**
     * @Route("/likes/check/comment/{comment_id}/{client_id}", name="check_comment_like_api");
     */
    public function onClickLikeCommentChecker(NormalizerInterface $norm, $comment_id, $client_id){
        $em = $this ->getDoctrine()->getManager();
        $like = $this ->getDoctrine()->getRepository(Likes :: class)->findBy(array('idClient'=>$client_id, 'idComment'=>$comment_id));
        if(empty($like)){
            return new Response(json_encode([["check" => "0"]]));
        }else{
            return new Response(json_encode([["check" => "1"]]));
        }
        return new Response(json_encode([["check" => "1"]]));
    }
}
