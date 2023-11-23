<?php

namespace App\Controller\public_api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;
use App\Entity\Article;
use App\Entity\Client;
use App\Form\ArticleAddFormType;
use App\Utils\Utilities;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class CommentApi extends AbstractController
{
    /**
     * @Route("/comments/add/{article_id}/{client_id}", name="comments_add")
     */
    public function addComment(NormalizerInterface $norm, $article_id, $client_id ,Request $req){
        $em = $this->getDoctrine()->getManager();
        $com = new Comment();
        $com->setContent($req->get('content'));
        $com->setId(Utilities::generateId($com, 'id', $this->getDoctrine()));
        $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"), "D M d, Y G:i");
        $com->setDate($dateTime);
        $article = $this->getDoctrine()->getRepository(Article::class)->find($article_id);
        $com->setArticle($article);
        $client = $this->getDoctrine()->getRepository(Client::class)->find($client_id);
        $com->setClient($client);
        $em->persist($com);
        $em->flush();
        
        $json = $norm->normalize($com, 'json', ['groups' => 'comment']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/comments/delete/{comment_id}", name="comments_delete")
     */
    public function delete(NormalizerInterface $norm, $comment_id){
        $com = new Comment();
        $em = $this ->getDoctrine()->getManager();
        $com=$em->getRepository(Comment::class)->find($comment_id);
        $em->remove($com);
        $em->flush();

        $json = $norm->normalize($com, 'json', ['groups' => ['comment']]);
        return new Response(json_encode($json));
    }
    /**
     * @Route("/comments/sort/sortliked/{article_id}", name="comments_sortliked")
     */
    public function sortByLike(NormalizerInterface $norm, $article_id){
        $comments = $this->getDoctrine()->getRepository(Comment::class)->getTopLiked($article_id);
        $json = $norm->normalize($comments, 'json', ['groups' => 'comment']);
        return new Response(json_encode($json));
    }
    /**
     * @Route("/comments/sort/sortnewest/{article_id}", name="comments_sortnew")
     */
    public function sortByNewest($article_id, NormalizerInterface $norm){
        $comments = $this->getDoctrine()->getRepository(Comment::class)->getNewest($article_id);
        $json = $norm->normalize($comments, 'json', ['groups' => 'comment']);
        return new Response(json_encode($json));
    }
    /**
     * @Route("/comments/get/{article_id}", name="comments_get")
     */
    public function getComments($article_id, NormalizerInterface $norm){
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['article_id' => $article_id]);
        $json = $norm->normalize($comments, 'json', ['groups' => 'comment']);
        return new Response(json_encode($json));
    }
}
