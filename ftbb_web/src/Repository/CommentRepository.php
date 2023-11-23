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
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }
    private function trans($arr){
        $a = array();
        for($i=0; $i<=count($arr)-1; $i++){
            $com = new Comment();
            $com->setId($arr[$i]['id']);
            $com->setContent($arr[$i]['content']);
            $cl = new Client();
            $cl->setName($arr[$i]['name']);
            $cl->setSurname($arr[$i]['surname']);
            $com->setClient($cl);
            $com->setDate($arr[$i]['date']);
            $lik = array();
            for($h=0; $h<=$arr[$i]['likes_count']-1; $h++){
                $like = new Likes();
                array_push($lik, $like);
            }
            $com->setLikes($lik);
            array_push($a, $com);
        }
        return $a;
    }
    public function getTopLiked($id){
    
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT comment.*, count(likes.id_like) as likes_count, client.name, client.surname from `comment` left join likes on likes.id_comment = comment.id inner join client on client.id = comment.client_id where article_id= :article_id group by comment.id order by likes_count DESC;';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['article_id' => $id]);
        $arr = $stmt->fetchAllAssociative();
        $a = array();
        for($i=0; $i<=count($arr)-1; $i++){
            $com = new Comment();
            $com->setId($arr[$i]['id']);
            $com->setContent($arr[$i]['content']);
            $cl = new Client();
            $cl->setName($arr[$i]['name']);
            $cl->setSurname($arr[$i]['surname']);
            $com->setClient($cl);
            $com->setDate($arr[$i]['date']);
            $lik = array();
            for($h=0; $h<=$arr[$i]['likes_count']-1; $h++){
                $like = new Likes();
                array_push($lik, $like);
            }
            $com->setLikes($lik);
            array_push($a, $com);
        }
        return $a;
    }
    public function getNewest($id){
        $sql="SELECT comment.*, client.name, client.surname FROM `comment` inner join client on comment.client_id=client.id where article_id= :article_id order by date DESC;";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['article_id' => $id]);
        $arr = $stmt->fetchAllAssociative();
        $a = array();
        for($i=0; $i<=count($arr)-1; $i++){
            $com = new Comment();
            $com->setId($arr[$i]['id']);
            $com->setContent($arr[$i]['content']);
            $cl = new Client();
            $cl->setName($arr[$i]['name']);
            $cl->setSurname($arr[$i]['surname']);
            $com->setClient($cl);
            $com->setDate($arr[$i]['date']);
            array_push($a, $com);
        }
        return $a;
    }
    public function search($text, $art_id){
        $sql = "SELECT  comment.*, client.name, client.surname FROM `comment` inner join client on comment.client_id=client.id where article_id = ".$art_id." and comment.content like '%".$text."%';";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $arr = $stmt->fetchAllAssociative();
        $a = array();
        for($i=0; $i<=count($arr)-1; $i++){
            $com = new Comment();
            $com->setId($arr[$i]['id']);
            $com->setContent($arr[$i]['content']);
            $cl = new Client();
            $cl->setName($arr[$i]['name']);
            $cl->setSurname($arr[$i]['surname']);
            $com->setClient($cl);
            $com->setDate($arr[$i]['date']);
            array_push($a, $com);
        }
        return $a;
    }
}
