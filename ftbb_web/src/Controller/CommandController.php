<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Command;
use App\Entity\CommandProduct;
use App\Entity\Product;
use App\Entity\Client;
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

class CommandController extends AbstractController
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
     * @Route("/command/list_command_admin", name="list_command_admin")
     */
    public function Afficher_command(): Response #objet min aand symfony jey par defaut
    {
        $command = $this ->getDoctrine()->getRepository(Command :: class)->findAll(); //findAll trajjalik tableau lkoll
        return $this->render('back/list_command_admin.html.twig', [
            'controller_name' => 'CommandControllerApi',
            'data'=> $command,
        ]);
    }

    /**
     * @Route("/command/modifier_status_admin/{commandId}", name="modifier_status")
     */
    public function modifier_status_admin(Request $req , $commandId , \Swift_Mailer $mailer): Response #objet min aand symfony jey par defaut
    {
        $command = new Command();
        $em = $this->getDoctrine()->getManager();
        $command = $em->getRepository(Command::class)->find($commandId);
        $client = $em->getRepository(Client::class)->find($command->getIdClient());
        if($command->getStatus()==0)
        {
            $command->setStatus(1);
        }
        $message = (new \Swift_Message('Commande validée !'))
            ->setFrom('ftbb.store@gmail.com')
            ->setTo($client->getEmail())
            ->setBody(
                'Cher Client,

Merci de faire vos achats sur FTBB store ! Votre commande 303925136 a été confirmée avec succès.

Elle sera à votre disposition dès que possible. Veuillez noter : Si vous avez depassé une semaine pour récupérer votre commande , elle va être annulée automatiquement.

Merci davoir fait vos achats sur  FTBB store.
    ');

        $mailer->send($message);

        $em->persist($command);
        $em->flush();

        return $this->redirectToRoute('list_command_admin');
    }

    /**
     * @Route("/command/list_command_client", name="list_command_client")
     */
    public function Afficher_command_client(): Response #objet min aand symfony jey par defaut
    {
        $commands = $this ->getDoctrine()->getRepository(Command :: class)->findBy(array('idClient' => 2) );
        //dd($commands);
        return $this->render('command/list_command_client.html.twig', [
            'controller_name' => 'CommandControllerApi',
            'data'=> $commands,
        ]);
    }

    /**
     * @Route("/command/add_new_command", name="add_new_command")
     */
    public function add_new_command()
    {
        $command=new Command();
        $entityManager = $this->getDoctrine()->getManager();
        $dateTime = Utilities::getDateTimeObject(date("D M d, Y G:i"),"D M d, Y G:i");
        $command->setDateCommand($dateTime);
        $command->setCommandId(Utilities::generateId($command,'commandId',$this->getDoctrine()));


        $carts = $this ->getDoctrine()->getRepository(Cart :: class)->findBy(array('idClient' => 2) );
        $x =null;
        $somme = 0;
        foreach($carts as $x){
            $command_product = new CommandProduct();
            $command_product->setIdCp(Utilities::generateId($command_product,'idCp',$this->getDoctrine()));
            $command_product->setRefProduct($x->getRefProduct());
            $somme = $somme + $x->getTotalPrice();
            $command_product->setIdClient(2);
            $command_product->setCommandId($command->getCommandId());
            $entityManager->persist($command_product);
            $entityManager->flush();
            $entityManager->remove($x);
            $entityManager->flush();
        }

        $command->setTotalPrice($somme);
        $command->setStatus(0);
        $command->setIdClient(2);
        $entityManager->persist($command);
        $entityManager->flush();
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/command/recherche_list_command_client",name="recherche_list_command_client")
     */
    public function Recherche_listcommandclient(CommandRepository $repository,Request $request)
    {
        $data=$request->get('search');
        $em=$repository->search($data);

        return $this->render('command/list_command_client.html.twig',[
            'data'=>$em

        ]);
    }

    /**
     * @Route("/command/recherche_list_command_admin",name="recherche_list_command_admin")
     */
    public function Recherche_listcommandadmin(CommandRepository $repository,Request $request)
    {
        $data=$request->get('search');
        $em=$repository->search($data);

        return $this->render('back/list_command_admin.html.twig',[
            'data'=>$em

        ]);
    }

    /**
     * @Route("/command/list_command_pdf", name="list_command_pdf")
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
