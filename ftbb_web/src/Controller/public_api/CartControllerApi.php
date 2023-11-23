<?php

namespace App\Controller\public_api;

use App\Entity\Cart;
use App\Entity\Product;
use App\Form\AjouterProductType;
use App\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CartControllerApi extends AbstractController
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
     * @Route("/mobile/product/cart/{id}", name="cart_mobile")
     */
    public function Afficher_product_cart($id, NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $carts = $this ->getDoctrine()->getRepository(Cart :: class)->findBy(array('cartId' => $id) ); //findAll trajjalik tableau lkoll
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
        //dd($carts);

        $json = $norm->normalize($carts, 'json', ['groups' => 'cart']);
        $json1 = json_encode($products, JSON_NUMERIC_CHECK);
        //dd($products);
        return new Response('[{"cart":'.json_encode($json).'},{"data":'.$json1.'}]');
    }
    /**
     * @Route("/mobile/cart/quant/{q}/{id}/{prod}"), name="add_quant_mobile")
     */
    public function addQuant($q, $id, $prod, NormalizerInterface $norm){
        $em = $this->getDoctrine()->getManager();
        $cart = $this ->getDoctrine()->getRepository(Cart :: class)->findBy(array('refProduct' => $prod, 'cartId' => $id));
        $cart[0]->setNumProducts($q);
        $prod =  $this ->getDoctrine()->getRepository(Product :: class)->findBy(array('refProduct' => $prod));
        $cart[0]->setTotalPrice($q * $prod[0]->getPrice());
        $em->persist($cart[0]);
        $em->flush();

        $p = $prod[0];
        $p->setStock($p->getStock() - $q);
        $em->persist($p);
        $em->flush();

        $carts = $this ->getDoctrine()->getRepository(Cart :: class)->findBy(array('cartId' => $id) ); //findAll trajjalik tableau lkoll
        $somme=0;
        $k=array();
        foreach($carts as $x){
            $somme=$somme+ $x->getTotalPrice();
        }
        return new Response(json_encode(""));    }
    /**
     * @Route("/mobile/cart/add/{id}/{clid}", name="add_to_cart_mobile")
     */
    public function addtocart($id, $clid, NormalizerInterface $norm)
    {
       $fine = $this->getDoctrine()->getRepository(Cart::class)->findBy(array('refProduct' => $id, 'cartId' => $clid));
        if($fine == NULL) {
            $cart = new Cart();
            $em = $this->getDoctrine()->getManager();
            $cart->setCartId($clid);
            $cart->setIdClient($clid);
            $cart->setNumProducts(1);
            $cart->setAdditionId(Utilities::generateId($cart, 'additionId', $this->getDoctrine()));
            $prod = $this->getDoctrine()->getRepository(Product :: class)->findBy(array('refProduct' => $id));
            $cart->setTotalPrice($prod[0]->getPrice());
            $cart->setRefproduct($id);
            $em->persist($cart);
            $em->flush();
        

        return new Response(json_encode([['exists' => '0']]));    }
            else{
                return new Response(json_encode([['exists' => '1']]));
            }
    }


    /**
     * @Route("/mobile/cart/supprimer/{refProduct}", name="supprimer_cart_mobile")
     */
    public function supprimer($refProduct,NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $cart = new Cart();
        $em = $this ->getDoctrine()->getManager();
        $product=$em->getRepository(Cart::class)->findBy(array('cartId' => 2,'refProduct'=>$refProduct)); //array trajja3 tableau houni el produit illi bech yattithoulna bech ykoun fi awel case fi tableau
        $em->remove($product[0]); //remove awell case fi tableau
        $em->flush();

        $json = $norm->normalize($cart, 'json', ['groups' => 'cart']);
        return new Response(json_encode($json));
        //return new Response("deleted successfully");
    }
}
