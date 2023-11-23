<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="admin_id", columns={"admin_id"})})

 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    public static $BREAKING_NEWS = "Breaking News";
    public static $HOT = "Hot";
    public static $ANNOUNCE = "Announce";
    public static $MISC = "Misc";

    /**
     * @var int
     *
     * @ORM\Column(name="article_id", type="integer", nullable=false)
     * @ORM\Id
     * @Groups("article")
     */
    private $articleId;

    /**
     * @var int
     *
     * @ORM\Column(name="admin_id", type="integer", nullable=false)
     * @Groups("article")
     */
    private $adminId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Groups("article")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=2048, nullable=false)
     * @Groups("article")
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=false)
     * @Groups("article")
     */
    private $author;

    /**

     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     * @Groups("article")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_url", type="string", length=255, nullable=false)
     * @Groups("article")
     */
    private $photoUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="category", type="integer", nullable=false)
     * @Groups("article")
     */
    private $category;

     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="article")
     * @Groups("article")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Likes", mappedBy="idArticle")
     * @Groups("article")
     */
    private $likes;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getArticleId(){
		return $this->articleId;
	}

	public function setArticleId($articleId){
               		$this->articleId = $articleId;
               	}

	public function getAdminId(){
               		return $this->adminId;
               	}

	public function setAdminId($adminId){
               		$this->adminId = $adminId;
               	}

  

	public function getTitle(){
               		return $this->title;
               	}

	public function setTitle($title){
               		$this->title = $title;
               	}

	public function getText(){
               		return $this->text;
               	}

	public function setText($text){
               		$this->text = $text;
               	}

	public function getAuthor(){
               		return $this->author;
               	}

	public function setAuthor($author){
               		$this->author = $author;
               	}

	public function getDate(){
               		return $this->date;
               	}

	public function setDate($date){
               		$this->date = $date;
               	}

	public function getPhotoUrl(){
               		return $this->photoUrl;
               	}

	public function setPhotoUrl($photoUrl){
               		$this->photoUrl = $photoUrl;
               	}

	public function getCategory(){
               		return $this->category;
               	}

	public function getComments(){
               		return $this->comments;
               	}
                   public function setComments($com){
                    $this->comments = $com;
                }

    public function getLikes(){
		return $this->likes;
	}

	public function setCategory($category){
               		$this->category = $category;
               	}
    public function getCommentsCount(){
        return count($this->comments);
    }
    public function getLikesCount(){
        return $this->likes->count();
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    public function addLike(Likes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setIdArticle($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getIdArticle() === $this) {
                $like->setIdArticle(null);
            }
        }

        return $this;
    }
    }