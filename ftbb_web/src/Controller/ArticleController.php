<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Client;
use App\Form\ArticleAddFormType;
use App\Form\CommentFormType;
use App\Utils\Utilities;

//use Symfony\Component\Validator\Constraints\DateTime;

class ArticleController extends AbstractController
{
    public static $CLIENT_ID = "122";

    /**
     * @Route("/articles", name="articles")
     */
    public function listArticles(): Response
    {
        $articles = $this ->getDoctrine()->getRepository(Article :: class)->findAll();
        return $this->render('article/articles.html.twig', ['articles' => $articles]);
    }
    /**
     * @Route("/a/articles", name="articles_admin")
     */
    public function listArticlesForAdmin(): Response
    {
        $articles = $this ->getDoctrine()->getRepository(Article :: class)->findAll();
        return $this->render('back/article-show-admin.html.twig', ['articles' => $articles]);
    }
    /**
     * @Route("/admin/article/delete/{id}", name="articles_admin_delete")
     */
    public function deleteArticle($id): Response
    {
        $article = new Article();
        $em = $this ->getDoctrine()->getManager();
        $report=$em->getRepository(Article::class)->find($id);
        $em->remove($report);
        $em->flush();
        return $this->redirectToRoute("articles_admin");
    }

    /**
     * @Route("/admin/article/modify/{id}", name="article_admin_mod")
     */
    public function modifyArticle(Request $req,$id)
    {
        $article = new Article();
        $form = $this ->createForm(ArticleAddFormType::class,$article); 
        $em = $this->getDoctrine()->getManager();
        $article=$em->getRepository(Article::class)->find($id);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            /*** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['url']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/images/articles_upload';

            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = '-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $article->setPhotoUrl("http://127.0.0.1/ftbb_web/ftbb_web/public/images/articles_upload/".$newFilename);

            $data=$form->getData();
            $article=$em->getRepository(Article::class)->find($id);
            $article->setTitle($data->getTitle());
            if(!empty($data->getText())){
                $article->setText($data->getText());
            }else{
                $article->setText($article->getText());
            }
            $article->setAuthor($data->getAuthor());
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute("articles_admin");
        }
        return $this->render('back/article-add-form.html.twig', [
            'article_add_form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * @Route("/articles/add", name="add_article")
     */
    public function addArticle(Request $req): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleAddFormType::class, $article);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            /*** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['url']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/images/articles_upload';

            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = '-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $article->setPhotoUrl("http://127.0.0.1/ftbb_web/ftbb_web/public/images/articles_upload/".$newFilename);
            $em = $this ->getDoctrine()->getManager();
            $article->setAdminId("47056258");
            $article->setArticleId(Utilities::generateId($article,'articleId', $this->getDoctrine()));
            $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"),"D M d, Y G:i");
            $article->setDate($dateTime);
            $em->persist($article);
            $em->flush();
            
            return $this->redirectToRoute("articles_admin");
        }
        return $this->render('back/article-add-form.html.twig', [
            'article_add_form' => $form->createView()
        ]);
    }


    /**
     * @Route("/articles/{id}", name="one_article")
     */
    public function showPost(Request $req, $id): Response
    {
        $com = new Comment();
        $form = $this->createForm(CommentFormType::class, $com);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            return $this->redirectToRoute("add_comment", ['id' => $id, 'content' => $form->getData()->getContent()]);
        }
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        return $this->render('article/article-post.html.twig', ['id_cli' =>ArticleController::$CLIENT_ID,'article' => $article, 'form' => $form->createView()]);
    }

    
    /**
     * @Route("/admin/articles/sort_liked", name="art_sort_liked")
     */
    public function sortByLiked(){
        $articles = $this->getDoctrine()->getRepository(Article::class)->getTopLiked();
        return $this->render('back/article-show-admin.html.twig', ['articles' => $articles]);
    }
    /**
     * @Route("/admin/articles/sort_comment", name="art_sort_commented")
     */
    public function sortByComments(){
        $articles = $this->getDoctrine()->getRepository(Article::class)->getMostCommented();
        return $this->render('back/article-show-admin.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/articles/last_sort/{time}" , name="last_sort")
     */
    public function lastSort($time){
        $articles = $this->getDoctrine()->getRepository(Article::class)->getTopLast($time);
        return $this->render('article/articles.html.twig', ['articles' => $articles]);
    }
    /**
     * @Route("/index", name="root")
     */
    public function root(){
        return $this->render('index.html.twig', []);
    }
}
