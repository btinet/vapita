<?php

namespace App\Controller;

use App\Entity\MainMenu;
use App\Form\MainMenuType;
use App\Repository\MainMenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/main/menu")
 */
class MainMenuController extends AbstractController
{
    /**
     * @Route("/", name="main_menu_index", methods={"GET"})
     */
    public function index(MainMenuRepository $mainMenuRepository): Response
    {
        return $this->render('main_menu/index.html.twig', [
            'main_menus' => $mainMenuRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="main_menu_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $mainMenu = new MainMenu();
        $form = $this->createForm(MainMenuType::class, $mainMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mainMenu);
            $entityManager->flush();

            return $this->redirectToRoute('main_menu_index');
        }

        return $this->render('main_menu/new.html.twig', [
            'main_menu' => $mainMenu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="main_menu_show", methods={"GET"})
     */
    public function show(MainMenu $mainMenu): Response
    {
        return $this->render('main_menu/show.html.twig', [
            'main_menu' => $mainMenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="main_menu_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MainMenu $mainMenu): Response
    {
        $form = $this->createForm(MainMenuType::class, $mainMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('main_menu_index');
        }

        return $this->render('main_menu/edit.html.twig', [
            'main_menu' => $mainMenu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="main_menu_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MainMenu $mainMenu): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mainMenu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mainMenu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('main_menu_index');
    }
}
