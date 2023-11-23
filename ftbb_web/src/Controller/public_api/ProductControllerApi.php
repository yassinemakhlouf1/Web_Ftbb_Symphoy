<?php

namespace App\Controller\public_api;
use App\Entity\Cart;
use App\Entity\Command;
use App\Repository\ProductRepository;
use App\Entity\CommandProduct;
use App\Utils\Utilities;
use App\Entity\Product;
use App\Form\AjouterProductType;
use App\Form\ModifierProductType;
use Ob\HighchartsBundle\Highcharts\Highchart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class ProductControllerApi extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductControllerApi',
        ]);
    }

    /**
     * @Route("/mobile/product/list_product_admin", name="list_product_admin_mobile")
     */
    public function Afficher_product(NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $product = $this->getDoctrine()->getRepository(Product :: class)->findAll(); //findAll trajjalik tableau lkoll
        $json = $norm->normalize($product, 'json', ['groups' => 'product']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/product/formulaire_ajout_admin", name="formulaire_ajout_mobile")
     */
    public function formulaire_ajout_admin(Request $req, NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $product = new Product();
        $ImageFile = $req->get('photo');
        $product->setPhoto($ImageFile);
        $entityManager = $this->getDoctrine()->getManager();
        $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"), "D M d, Y G:i");
        $product->setAddDate($dateTime);
        $product->setCategory($req->get('category'));
        $product->setName($req->get('name'));
        $product->setDetails($req-> get('details'));
        $product->setIdAdmin($req->get('id_admin'));
        $product->setStock($req->get('stock'));
        $product->setPrice($req->get('price'));
        $product->setRefProduct(Utilities::generateId($product, 'refProduct', $this->getDoctrine()));
        $entityManager->persist($product);
        $entityManager->flush();

        $this->addFlash(
            'info',
            'ajout effectué avec succès'
        );

        $json = $norm->normalize($product, 'json', ['groups' => 'product']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/product/formulaire_modifier_admin/{ref_product}", name="formulaire_modifier_mobile" )
     */
    public function formulaire_modifier_admin(Request $req, $ref_product, NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        /*$product = new Product();
         $form = $this ->createForm(ModifierProductType::class,$product); //houni snaana form fil controlleur w passinelou el classe illi yasna3 el form fi 7add dhetou w instance ta3 objet feragh
         $form->handleRequest($req);
         if($form->isSubmitted() && $form->isValid()){
             $data=$form->getData(); //houni khdhit tableau ta3 keys (add->'name' ta3 el valeur bidha illi mawjouda fi textfield)
             $em = $this->getDoctrine()->getManager();
             $product=$em->getRepository(product::class)->find($ref_product);
             $product->setCategory($data->getCategory());
             $product->setStock($data->getStock());
             $product->setName($data->getName());
             $product->setPrice($data->getPrice());
             $product->setDetails($data->getDetails());
             $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"),"D M d, Y G:i");
             $product->setAddDate($dateTime);
             $product->setIdAdmin($data->getIdAdmin());
             $product->setPhoto($data->getPhoto());
             $em->flush();

             return $this->redirectToRoute('list_product_admin');
         }*/

        $entityManager = $this->getDoctrine()->getManager();

        $product = $entityManager->getRepository(Product::class)->find($ref_product);
        $form = $this->createForm(ModifierProductType::class, $product);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

        }

        $json = $norm->normalize($product, 'json', ['groups' => 'product']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/product/supprimer/{ref_product}", name="supprimer_mobile")
     */
    public function supprimer($ref_product, NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $product = new Product();
        /*$classe->setId($id);
        $classe->setName($name);*/

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($ref_product);
        $em->remove($product);
        $em->flush();

        $json = $norm->normalize($product, 'json', ['groups' => 'product']);
        return new Response(json_encode($json));
        //return new Response("deleted successfully");
    }

    /********************************************************************************************************************************************************************************/
    /**
     * @Route("/mobile/product/list_product_client", name="list_product_client_mobile")
     */
    public function Afficher_product_client(NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $product = $this->getDoctrine()->getRepository(Product :: class)->findAll(); //findAll trajjalik tableau lkoll
        $json = $norm->normalize($product, 'json', ['groups' => 'product']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/command/list_product_command/{id}", name="product_command_mobile")
     */
    public function Afficher_product_command($id, NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $command_product = $this->getDoctrine()->getRepository(CommandProduct :: class)->findBy(array('commandId' => $id, 'idClient' => 2)); //findAll trajjalik tableau lkoll
        $products = array();
        foreach ($command_product as $x) {
            $prod = $this->getDoctrine()->getRepository(Product :: class)->find($x->getRefProduct());
            array_push($products, $prod);
        }
        $json = $norm->normalize($command_product, 'json', ['groups' => 'product']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/product/recherche",name="recherche_product_mobile")
     */
    public function Recherche(ProductRepository $repository, Request $request, NormalizerInterface $norm)
    {
        $data = $request->get('search');
        $em = $repository->search($data);

        $json = $norm->normalize($product, 'json', ['groups' => 'product']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/product/recherche_store",name="recherche_product_store_mobile")
     */
    public function Recherche_store(ProductRepository $repository, Request $request, NormalizerInterface $norm)
    {
        $data = $request->get('search');
        $em = $repository->search($data);

        $json = $norm->normalize($product, 'json', ['groups' => 'product']);
        return new Response(json_encode($json));
    }


    /**
     * @Route("/mobile/product/list_product_pdf", name="list_product_pdf_mobile")
     */
    public function pdf(ProductRepository $repository, Request $request): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $data = $request->get('search');
        $em = $repository->search($data);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('back/list_product_pdf.html.twig', [
            'data' => $em,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/mobile/product/stat", name="stat_mobile")
     */
    public function stat(NormalizerInterface $norm)
    {

        $product = $this->getDoctrine()->getRepository(Product :: class)->findAll(); //findAll trajjalik tableau lkoll
        //dd($product);
        $em = $this->getDoctrine()->getManager();
        $c1 = 0;
        $c2 = 0;
        $c3 = 0;


        foreach ($product as $product) {
            if ($product->getCategory() == 'Vêtements')  :

                $c1 += 1;
            elseif ($product->getCategory() == 'Equipements'):

                $c2 += 1;
            else :
                $c3 += 1;

            endif;

        }

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Categories', 'Nombres'],
                ['Vêtements', $c1],
                ['Equipements', $c2],
                ['Abonnements', $c3],

            ]
        );
        $pieChart->getOptions()->setTitle('Top Catégories');
        $pieChart->getOptions()->setHeight(600);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#EE3D00');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(40);

        $json = $norm->normalize($product, 'json', ['groups' => 'product']);
        return new Response(json_encode($json));
    }
}



