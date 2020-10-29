<?php

namespace App\Controller\Static;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/company", name="static_")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/impressum", name="impressum")
     */
    public function showImpressum()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}