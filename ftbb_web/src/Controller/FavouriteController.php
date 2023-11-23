<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Favourite;
use App\Entity\Product;
use App\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavouriteController extends AbstractController
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
     * @Route("/favourite/list_favourite", name="favourite")
     */
    public function Afficher_product_favourite(): Response #objet min aand symfony jey par defaut
    {
        $favourites = $this ->getDoctrine()->getRepository(Favourite :: class)->findBy(array('idClient' => 2) ); //findAll trajjalik tableau lkoll
        $products = array();
        $x =null;
        foreach($favourites as $x){
            $product = $this ->getDoctrine()->getRepository(Product :: class)->find($x->getRefproduct());
            array_push($products, $product);
        }
        return $this->render('favourite/list_favourite.html.twig', [
            'controller_name' => 'ProductControllerApi',
            'data'=> $products,
        ]);
    }

    /**
     * @Route("/favourite/add/{id}", name="add_to_favourite")
     */
    public function addtofavourite($id)
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
        return $this->redirectToRoute('list_product_client');
    }

    /**
     * @Route("/favourite/supprimer/{refProduct}", name="supprimer_favourite")
     */
    public function supprimer($refProduct): Response #objet min aand symfony jey par defaut
    {
        $favourite = new Favourite();
        $em = $this ->getDoctrine()->getManager();
        $product=$em->getRepository(Favourite::class)->findBy(array('idClient' => 2,'refProduct'=>$refProduct)); //array trajja3 tableau houni el produit illi bech yattithoulna bech ykoun fi awel case fi tableau
        $em->remove($product[0]); //remove awell case fi tableau
        $em->flush();

        return $this->redirectToRoute('favourite');
        //return new Response("deleted successfully");
    }

}
