<?php

namespace App\Controller\Admin;

use App\Entity\PostFile;
use App\Form\PostFileType;
use App\Repository\PostFileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/postfile")
 */
class PostFileController extends AbstractController
{
    /**
     * @Route("/", name="post_file_index", methods={"GET"})
     */
    public function index(PostFileRepository $postFileRepository): Response
    {
        return $this->render('post_file/index.html.twig', [
            'post_files' => $postFileRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="post_file_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $postFile = new PostFile();
        $form = $this->createForm(PostFileType::class, $postFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($postFile);
            $entityManager->flush();

            return $this->redirectToRoute('post_file_index');
        }

        return $this->render('post_file/new.html.twig', [
            'post_file' => $postFile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_file_show", methods={"GET"})
     */
    public function show(PostFile $postFile): Response
    {
        return $this->render('post_file/show.html.twig', [
            'post_file' => $postFile,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_file_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PostFile $postFile): Response
    {
        $form = $this->createForm(PostFileType::class, $postFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_file_index');
        }

        return $this->render('post_file/edit.html.twig', [
            'post_file' => $postFile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_file_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PostFile $postFile): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postFile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($postFile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_file_index');
    }
}
