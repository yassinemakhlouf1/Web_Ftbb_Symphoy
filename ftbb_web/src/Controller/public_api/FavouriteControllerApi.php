<?php

namespace App\Controller\public_api;

use App\Entity\Cart;
use App\Entity\Favourite;
use App\Entity\Product;
use App\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class FavouriteControllerApi extends AbstractController
{
    /**
     * @Route("/favourite/controller/php", name="favourite")
     */
    public function index(): Response
    {
        return $this->render('favourite/index.html.twig', [
            'controller_name' => 'FavouriteControllerApi',
        ]);
    }

    /**
     * @Route("/mobile/favourite/list_favourite", name="favourite_mobile")
     */
    public function Afficher_product_favourite(NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $favourites = $this ->getDoctrine()->getRepository(Favourite :: class)->findBy(array('idClient' => 2) ); //findAll trajjalik tableau lkoll
        $products = array();
        $x =null;
        foreach($favourites as $x){
            $product = $this ->getDoctrine()->getRepository(Product :: class)->find($x->getRefproduct());
            array_push($products, $product);
        }
        $json = $norm->normalize($favourites, 'json', ['groups' => 'favourite']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/favourite/add/{id}", name="add_to_favourite_mobile")
     */
    public function addtofavourite($id,NormalizerInterface $norm)
    {
        $product = $this->getDoctrine()->getRepository(Favourite::class)->findBy(array('refProduct'=>$id));
        if($product==NULL) {
            $favourite = new Favourite();
            $em = $this->getDoctrine()->getManager();
            $favourite->setIdClient(2);
            $favourite->setIdFav(Utilities::generateId($favourite, 'idFav', $this->getDoctrine()));
            $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
            $favourite->setRefProduct($product);
            $em->persist($favourite);
            $em->flush();

        }
        $json = $norm->normalize($product, 'json', ['groups' => 'favourite']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/favourite/supprimer/{refProduct}", name="supprimer_favourite_mobile")
     */
    public function supprimer($refProduct,NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $favourite = new Favourite();
        $em = $this ->getDoctrine()->getManager();
        $product=$em->getRepository(Favourite::class)->findBy(array('idClient' => 2,'refProduct'=>$refProduct)); //array trajja3 tableau houni el produit illi bech yattithoulna bech ykoun fi awel case fi tableau
        $em->remove($product[0]); //remove awell case fi tableau
        $em->flush();

        $json = $norm->normalize($favourite, 'json', ['groups' => 'favourite']);
        return new Response(json_encode($json));
        //return new Response("deleted successfully");
    }

}
