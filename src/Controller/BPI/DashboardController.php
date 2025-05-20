<?php

namespace App\Controller\BPI;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/bpi')]
#[IsGranted('ROLE_BPI')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'bpi_dashboard')]
    public function index(): Response
    {
        return $this->render('bpi/dashboard/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    #[Route('/entries', name: 'bpi_entries')]
    public function entries(): Response
    {
        return $this->render('bpi/dashboard/entries.html.twig');
    }

    #[Route('/entries/{id}', name: 'bpi_entry_show')]
    public function showEntry(int $id): Response
    {
        return $this->render('bpi/dashboard/show_entry.html.twig', [
            'entry_id' => $id
        ]);
    }

    #[Route('/entries/{id}/inspect', name: 'bpi_entry_inspect')]
    public function inspectEntry(int $id): Response
    {
        return $this->render('bpi/dashboard/inspect_entry.html.twig', [
            'entry_id' => $id
        ]);
    }

    #[Route('/reports', name: 'bpi_reports')]
    public function reports(): Response
    {
        return $this->render('bpi/dashboard/reports.html.twig');
    }

    #[Route('/announcements', name: 'bpi_announcements')]
    public function announcements(): Response
    {
        return $this->render('bpi/dashboard/announcements.html.twig');
    }
} 