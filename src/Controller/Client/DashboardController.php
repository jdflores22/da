<?php

namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/client/dashboard')]
#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'client_dashboard')]
    public function index(): Response
    {
        return $this->render('client/dashboard/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    #[Route('/entries', name: 'app_client_entries')]
    public function entries(): Response
    {
        return $this->render('client/dashboard/entries.html.twig');
    }

    #[Route('/entries/new', name: 'app_client_entries_new')]
    public function newEntry(): Response
    {
        return $this->render('client/dashboard/new_entry.html.twig');
    }

    #[Route('/inspection-photos', name: 'app_client_inspection_photos')]
    public function inspectionPhotos(): Response
    {
        return $this->render('client/dashboard/inspection_photos.html.twig');
    }

    #[Route('/announcements', name: 'app_client_announcements')]
    public function announcements(): Response
    {
        return $this->render('client/dashboard/announcements.html.twig');
    }

    #[Route('/profile', name: 'app_client_profile')]
    public function profile(): Response
    {
        return $this->render('client/dashboard/profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/change-password', name: 'app_client_change_password')]
    public function changePassword(): Response
    {
        return $this->render('client/dashboard/change_password.html.twig');
    }
} 