<?php

namespace App\Entity;


use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Article;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="client_id", columns={"client_id"}), @ORM\Index(name="article_id", columns={"article_id"})})

 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * 
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @Groups({"article","comment"})
     */
    private $id;

    /**

    * @var int
    *
    * @ORM\Column(name="article_id", type="integer", nullable=false)
    * @Groups({"article","comment"})
    */
   private $article_id;
   
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255, nullable=false)
     * @Groups({"article","comment"})
     */
    private $content;

    /**


     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     * @Groups({"article","comment"})
     */
    private $date;

    /**
     * @var \Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article_id", referencedColumnName="article_id")
     * })
     * @Groups("comment")
     */
    private $article;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     * })
     * @Groups({"article","comment"})
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Likes", mappedBy="idComment")
     * @Groups({"article","comment"})
     */
    private $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    public function getArticle(){
      return $this->article;
    }
  
    public function setArticle($article){
      $this->article = $article;
    }
  
    public function getId(){
      return $this->id;
    }
  
    public function setId($id){
      $this->id = $id;
    }
  
    public function getContent(){
      return $this->content;
    }
  
    public function setContent($content){
      $this->content = $content;
    }
  
    public function getArticleId(){
      return $this->article_id;
    }
  
    public function setArticleId($art){
      $this->article_id = $art;
    }
  
    public function getClient(){
      return $this->client;
    }
  
    public function setClient($client){
      $this->client = $client;
    }
  
    public function getDate(){
      return $this->date;
    }
  
    public function setDate($date){
      $this->date = $date;
    }
    public function getLikes(){
      return $this->likes;
    }
    public function setLikes($arr){
       $this->likes = $arr;
    }
    public function getLikesCount(){
      return count($this->likes);
  }

    public function addLike(Likes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setIdComment($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getIdComment() === $this) {
                $like->setIdComment(null);
            }
        }

        return $this;
    }
}
