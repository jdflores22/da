<?php

namespace App\Controller\BFAR;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/bfar')]
#[IsGranted('ROLE_BFAR')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'bfar_dashboard')]
    public function index(): Response
    {
        return $this->render('bfar/dashboard/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    #[Route('/entries', name: 'bfar_entries')]
    public function entries(): Response
    {
        return $this->render('bfar/dashboard/entries.html.twig');
    }

    #[Route('/entries/{id}', name: 'bfar_entry_show')]
    public function showEntry(int $id): Response
    {
        return $this->render('bfar/dashboard/show_entry.html.twig', [
            'entry_id' => $id
        ]);
    }

    #[Route('/entries/{id}/inspect', name: 'bfar_entry_inspect')]
    public function inspectEntry(int $id): Response
    {
        return $this->render('bfar/dashboard/inspect_entry.html.twig', [
            'entry_id' => $id
        ]);
    }

    #[Route('/reports', name: 'bfar_reports')]
    public function reports(): Response
    {
        return $this->render('bfar/dashboard/reports.html.twig');
    }

    #[Route('/announcements', name: 'bfar_announcements')]
    public function announcements(): Response
    {
        return $this->render('bfar/dashboard/announcements.html.twig');
    }
} 