<?php

namespace App\Controller\Admin;

use App\Entity\Announcement;
use App\Repository\AnnouncementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/announcements')]
#[IsGranted('ROLE_ADMIN')]
class AnnouncementController extends AbstractController
{
    #[Route('/', name: 'admin_announcements_index', methods: ['GET'])]
    public function index(AnnouncementRepository $announcementRepository): Response
    {
        return $this->render('admin/announcements/index.html.twig', [
            'announcements' => $announcementRepository->findRecentAnnouncements(50),
        ]);
    }

    #[Route('/new', name: 'admin_announcements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $announcement = new Announcement();
        $announcement->setUser($this->getUser());

        if ($request->isMethod('POST')) {
            $announcement->setTitle($request->request->get('title'));
            $announcement->setContent($request->request->get('content'));
            $announcement->setIsActive($request->request->get('isActive', true));

            $entityManager->persist($announcement);
            $entityManager->flush();

            $this->addFlash('success', 'Announcement created successfully');
            return $this->redirectToRoute('admin_announcements_index');
        }

        return $this->render('admin/announcements/new.html.twig', [
            'announcement' => $announcement,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_announcements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Announcement $announcement, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $announcement->setTitle($request->request->get('title'));
            $announcement->setContent($request->request->get('content'));
            $announcement->setIsActive($request->request->get('isActive', true));
            $announcement->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->flush();

            $this->addFlash('success', 'Announcement updated successfully');
            return $this->redirectToRoute('admin_announcements_index');
        }

        return $this->render('admin/announcements/edit.html.twig', [
            'announcement' => $announcement,
        ]);
    }

    #[Route('/{id}', name: 'admin_announcements_delete', methods: ['POST'])]
    public function delete(Request $request, Announcement $announcement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$announcement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($announcement);
            $entityManager->flush();
            $this->addFlash('success', 'Announcement deleted successfully');
        }

        return $this->redirectToRoute('admin_announcements_index');
    }
} 