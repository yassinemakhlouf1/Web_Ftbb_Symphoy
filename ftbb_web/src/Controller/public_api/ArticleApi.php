<?php

namespace App\Controller\public_api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Utils\Utilities;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ArticleApi extends AbstractController
{

    /**
     * @Route("/articles/get/all", name="articles_getall")
     */
    public function listArticles(NormalizerInterface $normalizer){
        $articles = $this ->getDoctrine()->getRepository(Article :: class)->findAll();
        $json = $normalizer->normalize($articles, 'json', ['groups' => 'article']);
        return new Response(json_encode($json));
    }
    /**
     * @Route("/articles/delete/{id}", name="articles_delete")
     */
    public function deleteArticle(NormalizerInterface $norm, $id)
    {
        $em = $this ->getDoctrine()->getManager();
        $article=$em->getRepository(Article::class)->find($id);
        $em->remove($article);
        $em->flush();
        $json = $norm->normalize($article, 'json', ['groups' => 'article']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/articles/modify/{id}", name="articles_mod")
     */
    public function modifyArticle(NormalizerInterface $norm, Request $req,$id)
    {
        $article = new Article();
        $em = $this->getDoctrine()->getManager();
        $article=$em->getRepository(Article::class)->find($id);
        /*** @var UploadedFile $uploadedFile */
        $uploadedFile = $req->get('photoUrl');
        $destination = $this->getParameter('kernel.project_dir').'/public/images/articles_upload';
        $newFilename = '-'.uniqid().'.'.$uploadedFile->guessExtension();
        $uploadedFile->move(
            $destination,
            $newFilename
        );
        $article->setPhotoUrl("http://127.0.0.1/ftbb_web/ftbb_web/public/images/articles_upload/".$newFilename);

        $article=$em->getRepository(Article::class)->find($id);
        $article->setTitle($req->get('title'));
        if(!empty($req->get('text'))){
            $article->setText($req->get('text'));
        }else{
            $article->setText($article->getText());
        }
        $article->setAuthor($req->get('author'));
        $em->persist($article);
        $em->flush();
        
        $json = $norm->normalize($article, 'json', ['groups' => 'article']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/articles/add", name="articles_add")
     */
    public function addArticle(Request $req, NormalizerInterface $norm)
    {
        $article = new Article();
        /*** @var UploadedFile $uploadedFile */
        $uploadedFile = $req->get('photoUrl');
        $destination = $this->getParameter('kernel.project_dir').'/public/images/articles_upload';

        $newFilename = '-'.uniqid().'.'.$uploadedFile->guessExtension();
        $uploadedFile->move(
            $destination,
            $newFilename
        );
        $article->setPhotoUrl("http://127.0.0.1/ftbb_web/ftbb_web/public/images/articles_upload/".$newFilename);
        $em = $this ->getDoctrine()->getManager();
        $article->setAdminId($req->get('admin_id'));
        $article->setArticleId(Utilities::generateId($article,'articleId', $this->getDoctrine()));
        $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"),"D M d, Y G:i");
        $article->setDate($dateTime);
        $em->persist($article);
        $em->flush();

        $json = $norm->normalize($article, 'json', ['groups' => 'article']);
        return new Response(json_encode($json));
    }


    /**
     * @Route("/articles/get/{id}", name="articles_get")
     */
    public function getArticle(NormalizerInterface $norm, $id)
    {
        $articles = $this ->getDoctrine()->getRepository(Article :: class)->findBy(['articleId' => $id]);
        $json = $norm->normalize($articles[0], 'json', ['groups' => 'article']);
        return new Response(json_encode($json));
    }

    
    /**
     * @Route("/articles/sort/sortliked", name="articles_sortliked")
     */
    public function sortByLiked(NormalizerInterface $norm){
        $articles = $this->getDoctrine()->getRepository(Article::class)->getTopLiked();
        $json = $norm->normalize($articles, 'json', ['groups' => 'article']);
        return new Response(json_encode($json));
    }
    /**
     * @Route("/articles/sort/mostcomment", name="articles_mostcomment")
     */
    public function sortByComments(NormalizerInterface $norm){
        $articles = $this->getDoctrine()->getRepository(Article::class)->getMostCommented();
        $json = $norm->normalize($articles, 'json', ['groups' => 'article']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/articles/sort/newest/{time}" , name="articles_newest")
     */
    public function lastSort(NormalizerInterface $norm, $time){
        $articles = $this->getDoctrine()->getRepository(Article::class)->getTopLast($time);
        $json = $norm->normalize($articles, 'json', ['groups' => 'article']);
        return new Response(json_encode($json));
    }
}
