<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Likes
 *
 * @ORM\Table(name="likes", indexes={@ORM\Index(name="id_comment", columns={"id_comment"}), @ORM\Index(name="id_article", columns={"id_article"}), @ORM\Index(name="id_client", columns={"id_client"})})
 * @ORM\Entity
 */
class Likes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_like", type="integer", nullable=false)
     * @ORM\Id
     * @Groups({"comment", "likes", "article"})
     */
    private $idLike;

    /**



     * @var \Comment
     *
     * @ORM\ManyToOne(targetEntity="Comment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_comment", referencedColumnName="id")
     * })
     * @Groups("likes")
     */
    private $idComment;

    /**
     * @var \Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_article", referencedColumnName="article_id")
     * })
     * @Groups("likes")
     */
    private $idArticle;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     * @Groups("likes")
     */
    private $idClient;
	public function getIdLike(){
		return $this->idLike;
	}

	public function setIdLike($idLike){
		$this->idLike = $idLike;
	}

	public function getIdComment(){
		return $this->idComment;
	}

	public function setIdComment($idComment){
		$this->idComment = $idComment;
	}

	public function getIdArticle(){
		return $this->idArticle;
	}

	public function setIdArticle($idArticle){
		$this->idArticle = $idArticle;
	}

	public function getIdClient(){
		return $this->idClient;
	}

	public function setIdClient($idClient){
		$this->idClient = $idClient;
	}

}
