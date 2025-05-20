<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_admin_dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/users', name: 'app_admin_users')]
    public function users(): Response
    {
        return $this->render('admin/dashboard/users.html.twig');
    }

    #[Route('/entries', name: 'app_admin_entries')]
    public function entries(): Response
    {
        return $this->render('admin/dashboard/entries.html.twig');
    }

    #[Route('/announcements', name: 'app_admin_announcements')]
    public function announcements(): Response
    {
        return $this->render('admin/dashboard/announcements.html.twig');
    }

    #[Route('/reports', name: 'app_admin_reports')]
    public function reports(): Response
    {
        return $this->render('admin/dashboard/reports.html.twig');
    }

    #[Route('/settings', name: 'app_admin_settings')]
    public function settings(): Response
    {
        return $this->render('admin/dashboard/settings.html.twig');
    }
} 