<?php

namespace App\Controller\BAI;

use App\Entity\Entry;
use App\Repository\EntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/bai')]
#[IsGranted('ROLE_BAI')]
class DashboardController extends AbstractController
{
    private $entryRepository;

    public function __construct(EntryRepository $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    #[Route('/dashboard', name: 'bai_dashboard')]
    public function index(): Response
    {
        $entries = $this->entryRepository->findBy(['agency' => 'bai'], ['submissionDate' => 'DESC']);
        
        return $this->render('bai/dashboard/index.html.twig', [
            'entries' => $entries,
            'user' => $this->getUser()
        ]);
    }

    #[Route('/entries', name: 'bai_entries')]
    public function entries(Request $request): Response
    {
        $status = $request->query->get('status');
        $type = $request->query->get('type');
        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');

        $criteria = ['agency' => 'bai'];
        
        if ($status) {
            $criteria['status'] = $status;
        }
        
        if ($type) {
            $criteria['animalType'] = $type;
        }

        $entries = $this->entryRepository->findBy($criteria, ['submissionDate' => 'DESC']);

        // Filter by date range if provided
        if ($startDate && $endDate) {
            $startDateTime = new \DateTimeImmutable($startDate);
            $endDateTime = new \DateTimeImmutable($endDate);
            $endDateTime = $endDateTime->setTime(23, 59, 59);

            $entries = array_filter($entries, function($entry) use ($startDateTime, $endDateTime) {
                return $entry->getSubmissionDate() >= $startDateTime && $entry->getSubmissionDate() <= $endDateTime;
            });
        }

        return $this->render('bai/dashboard/entries.html.twig', [
            'entries' => $entries
        ]);
    }

    #[Route('/entry/{id}', name: 'bai_entry_show')]
    public function showEntry(int $id): Response
    {
        $entry = $this->entryRepository->find($id);

        if (!$entry || $entry->getAgency() !== 'bai') {
            throw $this->createNotFoundException('Entry not found');
        }

        return $this->render('bai/dashboard/show_entry.html.twig', [
            'entry' => $entry
        ]);
    }

    #[Route('/entry/{id}/inspect', name: 'bai_entry_inspect')]
    public function inspectEntry(int $id): Response
    {
        $entry = $this->entryRepository->find($id);

        if (!$entry || $entry->getAgency() !== 'bai') {
            throw $this->createNotFoundException('Entry not found');
        }

        return $this->render('bai/dashboard/inspect_entry.html.twig', [
            'entry' => $entry,
            'entry_id' => $id
        ]);
    }

    #[Route('/entry/{id}/status', name: 'bai_entry_status', methods: ['POST'])]
    public function updateStatus(int $id, Request $request): JsonResponse
    {
        $entry = $this->entryRepository->find($id);

        if (!$entry || $entry->getAgency() !== 'bai') {
            return new JsonResponse(['success' => false, 'message' => 'Entry not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $status = $data['status'] ?? null;

        if (!in_array($status, ['pending', 'for_inspection', 'awaiting_payment', 'approved', 'rejected'])) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid status'], 400);
        }

        $entry->setStatus($status);
        $entry->setUpdatedAt(new \DateTimeImmutable());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entry);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/reports', name: 'bai_reports')]
    public function reports(): Response
    {
        return $this->render('bai/dashboard/reports.html.twig');
    }

    #[Route('/announcements', name: 'bai_announcements')]
    public function announcements(): Response
    {
        return $this->render('bai/dashboard/announcements.html.twig');
    }
} 