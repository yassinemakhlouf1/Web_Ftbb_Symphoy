<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Client;
use App\Entity\Likes;
use App\Entity\Article;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }
    public function getTopLiked(){
        $sql = "SELECT article.*, count(likes.id_like) as likes_count from `article` left join likes on likes.id_article = article.article_id  group by article.article_id order by likes_count DESC;";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $arr = $stmt->fetchAllAssociative();
        $a = array();
        for($i=0; $i<=count($arr)-1; $i++){
            $com = new Article();
            $com->setArticleId($arr[$i]['article_id']);
            $com->setTitle($arr[$i]['title']);
            //$cl = new Admin();
            $com->setAdminId($arr[$i]['admin_id']);
            $com->setDate($arr[$i]['date']);
            $com->setText($arr[$i]['text']);
            $com->setAuthor($arr[$i]['author']);
            $com->setPhotoUrl($arr[$i]['photo_url']);
            $com->setCategory($arr[$i]['category']);
            $lik = array();
            $com->setComments($lik);
            array_push($a, $com);
        }
        return $a;
    }
    public function getMostCommented(){
        $sql = "SELECT article.*, count(comment.id) as comments_count from `article` left join comment on comment.article_id = article.article_id  group by article.article_id order by comments_count DESC;";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $arr = $stmt->fetchAllAssociative();
        $a = array();
        for($i=0; $i<=count($arr)-1; $i++){
            $com = new Article();
            $com->setArticleId($arr[$i]['article_id']);
            $com->setTitle($arr[$i]['title']);
            //$cl = new Admin();
            $com->setAdminId($arr[$i]['admin_id']);
            $com->setDate($arr[$i]['date']);
            $com->setText($arr[$i]['text']);
            $com->setAuthor($arr[$i]['author']);
            $com->setPhotoUrl($arr[$i]['photo_url']);
            $com->setCategory($arr[$i]['category']);
            $lik = array();
            for($h=0; $h<=$arr[$i]['comments_count']-1; $h++){
                $like = new Comment();
                array_push($lik, $like);
            }
            $com->setComments($lik);
            array_push($a, $com);
        }
        return $a;
    }
    public function getTopLast($time){

        switch($time){
            case 1:
                $query = "SELECT article.*, count(likes.id_like) as likes_count from `article` left join likes on likes.id_article = article.article_id where article.date > subdate(CURRENT_TIMESTAMP(), INTERVAL 6 hour)  group by article.article_id order by likes_count DESC;";
                break;
            case 2:
                $query = "SELECT article.*, count(likes.id_like) as likes_count from `article` left join likes on likes.id_article = article.article_id where article.date > subdate(CURRENT_TIMESTAMP(), INTERVAL 24 hour)  group by article.article_id order by likes_count DESC;";
                break;
            case 3:
                $query = "SELECT article.*, count(likes.id_like) as likes_count from `article` left join likes on likes.id_article = article.article_id  group by article.article_id order by likes_count DESC;";
                break;
            default:
            return;
            break;
        }

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $arr = $stmt->fetchAllAssociative();
        $a = array();
        for($i=0; $i<=count($arr)-1; $i++){
            $com = new Article();
            $com->setArticleId($arr[$i]['article_id']);
            $com->setTitle($arr[$i]['title']);
            //$cl = new Admin();
            $com->setAdminId($arr[$i]['admin_id']);
            $com->setDate($arr[$i]['date']);
            $com->setText($arr[$i]['text']);
            $com->setAuthor($arr[$i]['author']);
            $com->setPhotoUrl($arr[$i]['photo_url']);
            $com->setCategory($arr[$i]['category']);
            array_push($a, $com);
        }
        return $a;
    }
}
