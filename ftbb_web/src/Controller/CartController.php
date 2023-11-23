<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Form\AjouterProductType;
use App\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartControllerApi',
        ]);
    }

    /**
     * @Route("/product/cart", name="cart")
     */
    public function Afficher_product_cart(): Response #objet min aand symfony jey par defaut
    {
        $carts = $this ->getDoctrine()->getRepository(Cart :: class)->findBy(array('cartId' => 2) ); //findAll trajjalik tableau lkoll
        $products = array();
        $x =null;
        $somme=0;
        $k=array();
        foreach($carts as $x){
            $somme=$somme+ $x->getTotalPrice();
            $product = $this ->getDoctrine()->getRepository(Product :: class)->find($x->getRefproduct());
            array_push($products, $product);
            array_push($k,$x->getNumProducts());
        }
        // dd function tnejem testa3melha kima sout fl java
        return $this->render('cart.html.twig', [
            'controller_name' => 'ProductControllerApi',
            'data'=> $products,
            'total'=>$somme,
            'num'=>$k
        ]);
    }
    /**
     * @Route("/cart/quant/{q}/{id}"), name="add_quant")
     */
    public function addQuant($q, $id){
        $em = $this->getDoctrine()->getManager();
        $cart = $this ->getDoctrine()->getRepository(Cart :: class)->findBy(array('refProduct' => $id, 'cartId' => 2));
        $cart[0]->setNumProducts($q);
        $prod =  $this ->getDoctrine()->getRepository(Product :: class)->findBy(array('refProduct' => $id));
        $cart[0]->setTotalPrice($q * $prod[0]->getPrice());
        $em->persist($cart[0]);
        $em->flush();

        $p = $prod[0];
        $p->setStock($p->getStock() - $q);
        $em->persist($p);
        $em->flush();

        $carts = $this ->getDoctrine()->getRepository(Cart :: class)->findBy(array('cartId' => 2) ); //findAll trajjalik tableau lkoll
        $somme=0;
        $k=array();
        foreach($carts as $x){
            $somme=$somme+ $x->getTotalPrice();
        }
        return new JsonResponse(['stock' => $p->getstock(), 'tot' => $somme]);
    }
    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function addtocart($id)
    {
       $fine = $this->getDoctrine()->getRepository(Cart::class)->findBy(array('refProduct' => $id, 'cartId' => 2));
        if($fine == NULL) {
            $cart = new Cart();
            $em = $this->getDoctrine()->getManager();
            $cart->setCartId(2);
            $cart->setIdClient(2);
            $cart->setNumProducts(1);
            $cart->setAdditionId(Utilities::generateId($cart, 'additionId', $this->getDoctrine()));
            $prod = $this->getDoctrine()->getRepository(Product :: class)->findBy(array('refProduct' => $id));
            $cart->setTotalPrice($prod[0]->getPrice());
            $cart->setRefproduct($id);
            $em->persist($cart);
            $em->flush();
        }

            return new JsonResponse();
    }

    /**
     * @Route("/cart/supprimer/{refProduct}", name="supprimer_cart")
     */
    public function supprimer($refProduct): Response #objet min aand symfony jey par defaut
    {
        $cart = new Cart();
        $em = $this ->getDoctrine()->getManager();
        $product=$em->getRepository(Cart::class)->findBy(array('cartId' => 2,'refProduct'=>$refProduct)); //array trajja3 tableau houni el produit illi bech yattithoulna bech ykoun fi awel case fi tableau
        $em->remove($product[0]); //remove awell case fi tableau
        $em->flush();

        return $this->redirectToRoute('cart');
        //return new Response("deleted successfully");
    }
}
