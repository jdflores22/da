<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        // If user is authenticated, redirect to their appropriate dashboard
        if ($this->getUser()) {
            return $this->redirectToRoute('app_role_redirect');
        }
        
        // If not authenticated, show the public homepage
        return $this->render('base.html.twig');
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboardRedirect(): Response
    {
        return $this->redirectToRoute('app_admin_dashboard');
    }
} 