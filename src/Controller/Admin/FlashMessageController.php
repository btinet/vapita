<?php

namespace App\Controller;

use App\Entity\FlashMessage;
use App\Form\FlashMessageType;
use App\Repository\FlashMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/flash/message")
 */
class FlashMessageController extends AbstractController
{
    /**
     * @Route("/", name="flash_message_index", methods={"GET"})
     */
    public function index(FlashMessageRepository $flashMessageRepository): Response
    {
        return $this->render('flash_message/index.html.twig', [
            'flash_messages' => $flashMessageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="flash_message_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $flashMessage = new FlashMessage();
        $form = $this->createForm(FlashMessageType::class, $flashMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($flashMessage);
            $entityManager->flush();

            return $this->redirectToRoute('flash_message_index');
        }

        return $this->render('flash_message/new.html.twig', [
            'flash_message' => $flashMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="flash_message_show", methods={"GET"})
     */
    public function show(FlashMessage $flashMessage): Response
    {
        return $this->render('flash_message/show.html.twig', [
            'flash_message' => $flashMessage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="flash_message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FlashMessage $flashMessage): Response
    {
        $form = $this->createForm(FlashMessageType::class, $flashMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('flash_message_index');
        }

        return $this->render('flash_message/edit.html.twig', [
            'flash_message' => $flashMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="flash_message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FlashMessage $flashMessage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flashMessage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($flashMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('flash_message_index');
    }
}
