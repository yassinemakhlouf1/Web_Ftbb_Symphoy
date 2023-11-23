<?php

namespace App\Controller\public_api;

use App\Entity\Cart;
use App\Entity\Command;
use App\Entity\CommandProduct;
use App\Entity\Product;
use App\Form\ModifierProductType;
use App\Repository\CommandRepository;
use App\Repository\ProductRepository;
use App\Utils\Utilities;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class CommandControllerApi extends AbstractController
{
    /**
     * @Route("/command", name="command")
     */
    public function index(): Response
    {
        return $this->render('command/index.html.twig', [
            'controller_name' => 'CommandControllerApi',
        ]);
    }

    /**
     * @Route("/mobile/command/list_command_admin", name="list_command_admin_mobile")
     */
    public function Afficher_command(NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $command = $this ->getDoctrine()->getRepository(Command :: class)->findAll(); //findAll trajjalik tableau lkoll
        $json = $norm->normalize($command, 'json', ['groups' => 'command']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/command/modifier_status_admin/{commandId}", name="modifier_status_mobile")
     */
    public function modifier_status_admin(Request $req , $commandId , \Swift_Mailer $mailer, NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $command = new Command();
        $em = $this->getDoctrine()->getManager();
        $command = $em->getRepository(Command::class)->find($commandId);
        if($command->getStatus()==0)
        {
            $command->setStatus(1);
        }
        $message = (new \Swift_Message('Commande validée !'))
            ->setFrom('ftbb.store@gmail.com')
            ->setTo('ons.kechrid@esprit.tn')
            ->setBody(
                'Cher Client,

Merci de faire vos achats sur FTBB store ! Votre commande 303925136 a été confirmée avec succès.

Elle sera à votre disposition dès que possible. Veuillez noter : Si vous avez depassé une semaine pour récupérer votre commande , elle va être annulée automatiquement.

Merci davoir fait vos achats sur  FTBB store.
    ');

        $mailer->send($message);

        $em->persist($command);
        $em->flush();

        $json = $norm->normalize($command, 'json', ['groups' => 'command']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/command/list_command_client/{id}", name="list_command_client_mobile")
     */
    public function Afficher_command_client($id, NormalizerInterface $norm): Response #objet min aand symfony jey par defaut
    {
        $commands = $this ->getDoctrine()->getRepository(Command :: class)->findBy(array('idClient' => $id) );
        //dd($commands);
        $json = $norm->normalize($commands, 'json', ['groups' => 'command']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/command/add_new_command/{id}", name="add_new_command_mobile")
     */
    public function add_new_command($id, NormalizerInterface $norm)
    {
        $command=new Command();
        $entityManager = $this->getDoctrine()->getManager();
        $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"),"D M d, Y G:i");
        $command->setDateCommand($dateTime);
        $command->setCommandId(Utilities::generateId($command,'commandId',$this->getDoctrine()));


        $carts = $this ->getDoctrine()->getRepository(Cart :: class)->findBy(array('idClient' => $id) );
        $x =null;
        $somme = 0;
        foreach($carts as $x){
            $command_product = new CommandProduct();
            $command_product->setIdCp(Utilities::generateId($command_product,'idCp',$this->getDoctrine()));
            $command_product->setRefProduct($x->getRefProduct());
            $somme = $somme + $x->getTotalPrice();
            $command_product->setIdClient($id);
            $command_product->setCommandId($command->getCommandId());
            $entityManager->persist($command_product);
            $entityManager->flush();
            $entityManager->remove($x);
            $entityManager->flush();
        }

        $command->setTotalPrice($somme);
        $command->setStatus(0);
        $command->setIdClient($id);
        $entityManager->persist($command);
        $entityManager->flush();

        $json = $norm->normalize($command, 'json', ['groups' => 'command']);
        return new Response(json_encode($json));    }

    /**
     * @Route("/mobile/command/recherche_list_command_client",name="recherche_list_command_client_mobile")
     */
    public function Recherche_listcommandclient(CommandRepository $repository,Request $request,NormalizerInterface $norm)
    {
        $data=$request->get('search');
        $em=$repository->search($data);

        $json = $norm->normalize($command, 'json', ['groups' => 'command']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/command/recherche_list_command_admin",name="recherche_list_command_admin_mobile")
     */
    public function Recherche_listcommandadmin(CommandRepository $repository,Request $request,NormalizerInterface $norm)
    {
        $data=$request->get('search');
        $em=$repository->search($data);

        $json = $norm->normalize($command, 'json', ['groups' => 'command']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/mobile/command/list_command_pdf", name="list_command_pdf_mobile")
     */
    public function pdf(CommandRepository $repository,Request $request): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $data=$request->get('search');
        $em=$repository->search($data);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('back/list_command_pdf.html.twig', [
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


}
