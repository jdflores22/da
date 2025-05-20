<?php

namespace App\Controller\Admin;

use App\Entity\Entry;
use App\Repository\EntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/entries')]
#[IsGranted('ROLE_ADMIN')]
class EntryController extends AbstractController
{
    #[Route('/', name: 'admin_entries_index', methods: ['GET'])]
    public function index(EntryRepository $entryRepository): Response
    {
        return $this->render('admin/entries/index.html.twig', [
            'entries' => $entryRepository->findRecentEntries(50),
        ]);
    }

    #[Route('/new', name: 'admin_entries_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entry = new Entry();
        $entry->setUser($this->getUser());

        if ($request->isMethod('POST')) {
            $entry->setTitle($request->request->get('title'));
            $entry->setContent($request->request->get('content'));
            $entry->setStatus($request->request->get('status', 'draft'));

            $entityManager->persist($entry);
            $entityManager->flush();

            $this->addFlash('success', 'Entry created successfully');
            return $this->redirectToRoute('admin_entries_index');
        }

        return $this->render('admin/entries/new.html.twig', [
            'entry' => $entry,
        ]);
    }

    #[Route('/{id}', name: 'admin_entries_show', methods: ['GET'])]
    public function show(Entry $entry): Response
    {
        return $this->render('admin/entries/show.html.twig', [
            'entry' => $entry,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_entries_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entry $entry, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $entry->setTitle($request->request->get('title'));
            $entry->setContent($request->request->get('content'));
            $entry->setStatus($request->request->get('status'));
            $entry->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->flush();

            $this->addFlash('success', 'Entry updated successfully');
            return $this->redirectToRoute('admin_entries_index');
        }

        return $this->render('admin/entries/edit.html.twig', [
            'entry' => $entry,
        ]);
    }

    #[Route('/{id}', name: 'admin_entries_delete', methods: ['POST'])]
    public function delete(Request $request, Entry $entry, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entry->getId(), $request->request->get('_token'))) {
            $entityManager->remove($entry);
            $entityManager->flush();
            $this->addFlash('success', 'Entry deleted successfully');
        }

        return $this->redirectToRoute('admin_entries_index');
    }
} 