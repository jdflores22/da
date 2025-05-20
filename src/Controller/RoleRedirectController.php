<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Psr\Log\LoggerInterface;

class RoleRedirectController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route('/role-redirect', name: 'app_role_redirect')]
    public function index(Security $security): Response
    {
        try {
            $user = $security->getUser();
            
            if (!$user) {
                $this->logger->warning('Role redirect attempted without authenticated user');
                return $this->redirectToRoute('app_login');
            }

            $roles = $user->getRoles();
            
            if (empty($roles)) {
                $this->logger->warning('User has no roles assigned', ['user_id' => $user->getId()]);
                return $this->redirectToRoute('app_login');
            }

            // Check roles in order of priority
            if (in_array('ROLE_ADMIN', $roles)) {
                $this->logger->info('Redirecting admin user to dashboard', ['user_id' => $user->getId()]);
                return $this->redirectToRoute('app_admin_dashboard');
            }

            if (in_array('ROLE_BAI', $roles)) {
                $this->logger->info('Redirecting BAI user to dashboard', ['user_id' => $user->getId()]);
                return $this->redirectToRoute('bai_dashboard');
            }

            if (in_array('ROLE_BFAR', $roles)) {
                $this->logger->info('Redirecting BFAR user to dashboard', ['user_id' => $user->getId()]);
                return $this->redirectToRoute('bfar_dashboard');
            }

            if (in_array('ROLE_BPI', $roles)) {
                $this->logger->info('Redirecting BPI user to dashboard', ['user_id' => $user->getId()]);
                return $this->redirectToRoute('bpi_dashboard');
            }

            // Default to client dashboard for ROLE_USER
            $this->logger->info('Redirecting user to client dashboard', ['user_id' => $user->getId()]);
            return $this->redirectToRoute('client_dashboard');

        } catch (\Exception $e) {
            $this->logger->error('Error during role redirect', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return to login page in case of error
            return $this->redirectToRoute('app_login');
        }
    }
} 