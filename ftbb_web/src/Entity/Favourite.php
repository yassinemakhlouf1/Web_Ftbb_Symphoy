<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Favourite
 *
 * @ORM\Table(name="favourite", indexes={@ORM\Index(name="ref_product", columns={"ref_product"}), @ORM\Index(name="id_client", columns={"id_client"})})
 * @ORM\Entity
 */
class Favourite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_fav", type="integer", nullable=false)
     * @ORM\Id
     * @Groups("favourite")
     */
    private $idFav;

    /**
     * @var int
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     * @Groups("favourite")
     */
    private $idClient;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_product", referencedColumnName="ref_product")
     * })
     * @Groups("favourite")
     */
    private $refProduct;

    public function getIdFav(){
        return $this->idFav;
    }

    public function setIdFav($idFav){
        $this->idFav = $idFav;
    }

    public function getIdClient(){
        return $this->idClient;
    }

    public function setIdClient($idClient){
        $this->idClient = $idClient;
    }

    public function getRefProduct(){
        return $this->refProduct;
    }

    public function setRefProduct($refProduct){
        $this->refProduct = $refProduct;
    }
}
