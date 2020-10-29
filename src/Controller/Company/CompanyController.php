<?php

namespace App\Controller\Company;

use App\Entity\Contact;
use App\Form\Contact1Type;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="company_", priority=2)
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/impressum", name="impressum")
     */
    public function impressum()
    {
        $mainMenuRepository = $this->getDoctrine()->getRepository('App:MainMenu');
        $mainMenu = $mainMenuRepository->findAll();


        return $this->render('static/index.html.twig', [
            'controller_name' => 'Impressum',
            'controller_content' => 'static/impressum.html.twig',
            'main_menu' => $mainMenu,
            'current_main_menu' => null
        ]);
    }

    /**
     * @Route("/datenschutz", name="datenschutz")
     */
    public function datenschutz()
    {
        $mainMenuRepository = $this->getDoctrine()->getRepository('App:MainMenu');
        $mainMenu = $mainMenuRepository->findAll();


        return $this->render('static/impressum.html.twig', [
            'controller_name' => 'Datenschutz',
            'main_menu' => $mainMenu,
            'current_main_menu' => null
        ]);
    }

    /**
     * @Route("/agb", name="agb")
     */
    public function agb()
    {
        $mainMenuRepository = $this->getDoctrine()->getRepository('App:MainMenu');
        $mainMenu = $mainMenuRepository->findAll();


        return $this->render('static/impressum.html.twig', [
            'controller_name' => 'Allgemeine Geschäftsbedingungen',
            'main_menu' => $mainMenu,
            'current_main_menu' => null
        ]);
    }

    /**
     * @Route("/kontakt", name="kontakt", methods={"GET","POST"})
     */
    public function kontakt(Request $request, MailerInterface $mailer): Response
    {
        $mainMenuRepository = $this->getDoctrine()->getRepository('App:MainMenu');
        $mainMenu = $mainMenuRepository->findAll();

        $stateRepository = $this->getDoctrine()->getRepository('App:States');
        $states = $stateRepository->findAllOrderedByName('ASC');

        $contact = new Contact();
        $form = $this->createForm(Contact1Type::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            $email = (new TemplatedEmail())
            ->from('benjamin.voigt@vapita.de')
            ->to($contact->getEmail())
            ->subject($contact->getTitle().' | Vapita Mediengestaltung')
            ->htmlTemplate('email/contact.html.twig')
            ->context([
                'firstname' => $contact->getFirstname(),
                'lastname' => $contact->getLastname(),
                'content' => $contact->getContent(),
                'subject' => $contact->getTitle()
            ]);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e){
                $this->addFlash('warning', $e->getMessage());
            }


            $this->addFlash('success', 'Deine Nachricht hat uns erreicht!');

            return $this->redirectToRoute('company_kontakt');
        }

        return $this->render('static/index.html.twig', [
            'controller_name' => 'Kontakt',
            'controller_content' => 'static/kontakt.html.twig',
            'main_menu' => $mainMenu,
            'current_main_menu' => null,
            'contact' => $contact,
            'form' => $form->createView(),
            'states' => $states,
        ]);
    }

}