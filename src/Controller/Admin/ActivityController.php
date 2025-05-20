<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/activity')]
#[IsGranted('ROLE_ADMIN')]
class ActivityController extends AbstractController
{
    #[Route('/', name: 'admin_activity')]
    public function index(ActivityRepository $activityRepository): Response
    {
        $activities = $activityRepository->findRecentActivities(50);

        return $this->render('admin/dashboard/activity.html.twig', [
            'activities' => $activities,
        ]);
    }
} 