<?php

namespace App\Controller\Admin;

use App\Entity\Report;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/reports')]
#[IsGranted('ROLE_ADMIN')]
class ReportController extends AbstractController
{
    #[Route('/', name: 'admin_reports', methods: ['GET'])]
    public function index(ReportRepository $reportRepository): Response
    {
        return $this->render('admin/reports/index.html.twig', [
            'reports' => $reportRepository->findRecentReports(50),
        ]);
    }

    #[Route('/new', name: 'admin_reports_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $report = new Report();
        $report->setUser($this->getUser());

        if ($request->isMethod('POST')) {
            $report->setTitle($request->request->get('title'));
            $report->setContent($request->request->get('content'));
            $report->setType($request->request->get('type'));
            $report->setStatus($request->request->get('status', 'pending'));

            $entityManager->persist($report);
            $entityManager->flush();

            $this->addFlash('success', 'Report created successfully');
            return $this->redirectToRoute('admin_reports');
        }

        return $this->render('admin/reports/new.html.twig', [
            'report' => $report,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_reports_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Report $report, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $report->setTitle($request->request->get('title'));
            $report->setContent($request->request->get('content'));
            $report->setType($request->request->get('type'));
            $report->setStatus($request->request->get('status'));
            $report->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->flush();

            $this->addFlash('success', 'Report updated successfully');
            return $this->redirectToRoute('admin_reports');
        }

        return $this->render('admin/reports/edit.html.twig', [
            'report' => $report,
        ]);
    }

    #[Route('/{id}', name: 'admin_reports_delete', methods: ['POST'])]
    public function delete(Request $request, Report $report, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$report->getId(), $request->request->get('_token'))) {
            $entityManager->remove($report);
            $entityManager->flush();
            $this->addFlash('success', 'Report deleted successfully');
        }

        return $this->redirectToRoute('admin_reports');
    }
} 