<?php

namespace App\Controller\Admin;

use App\Entity\ImageGallery;
use App\Form\ImageGalleryType;
use App\Repository\ImageGalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/image_gallery")
 */
class ImageGalleryController extends AbstractController
{
    /**
     * @Route("/", name="image_gallery_index", methods={"GET"})
     */
    public function index(ImageGalleryRepository $imageGalleryRepository): Response
    {
        return $this->render('image_gallery/index.html.twig', [
            'image_galleries' => $imageGalleryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="image_gallery_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $imageGallery = new ImageGallery();
        $form = $this->createForm(ImageGalleryType::class, $imageGallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($imageGallery);
            $entityManager->flush();

            return $this->redirectToRoute('image_gallery_index');
        }

        return $this->render('image_gallery/new.html.twig', [
            'image_gallery' => $imageGallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="image_gallery_show", methods={"GET"})
     */
    public function show(ImageGallery $imageGallery): Response
    {
        return $this->render('image_gallery/show.html.twig', [
            'image_gallery' => $imageGallery,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="image_gallery_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ImageGallery $imageGallery): Response
    {
        $form = $this->createForm(ImageGalleryType::class, $imageGallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('image_gallery_index');
        }

        return $this->render('image_gallery/edit.html.twig', [
            'image_gallery' => $imageGallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="image_gallery_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ImageGallery $imageGallery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imageGallery->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($imageGallery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('image_gallery_index');
    }
}
