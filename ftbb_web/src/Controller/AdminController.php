<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Client;
use App\Form\AdminType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{


    /**
     * @Route("/", name="admin_index", methods={"GET"})
     */
    public function index(Request $request):response
    {
        $admin = new Admin() ;
        $var = $request->query->get('users');
        if ($var != "") {

            $query = $this->getDoctrine()->getRepository(Admin::class)->createQueryBuilder('u');
            $query->where('u.name LIKE :title')
                ->setParameter("title", "%$var%")
                ->getQuery();


            $admin  = $query->getQuery()->getResult();

        } else {
            $admin  = $this->getDoctrine()
                ->getRepository(Admin::class)
                ->findAll();
        }
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'Admin' => $admin,
        ]);}
//        public function index(): Response
//    {
//        $admins = $this->getDoctrine()
//            ->getRepository(Admin::class)
//            ->findAll();
//
//        return $this->render('admin/index.html.twig', [
//            'admins' => $admins,
//        ]);
//    }
    /**
     * @Route("/userliste", name="client_list", methods={"GET"})
     */
    public function listeclient  (Request $request):response
    {
        $client = new Client() ;
        $var = $request->query->get('users');
        if ($var != "") {

            $query = $this->getDoctrine()->getRepository(Client::class)->createQueryBuilder('u');
            $query->where('u.name LIKE :title')
                ->setParameter("title", "%$var%")
                ->getQuery();


            $client  = $query->getQuery()->getResult();

        } else {
            $client  = $this->getDoctrine()
                ->getRepository(Client::class)
                ->findAll();
        }
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'Client' => $client,
        ]);
    }
    /**
     * @Route("/new", name="admin_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_show", methods={"GET"})
     */
    public function show(Admin $admin): Response
    {
        return $this->render('admin/show.html.twig', [
            'admin' => $admin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Admin $admin): Response
    {
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/edit.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Admin $admin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($admin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }
}
