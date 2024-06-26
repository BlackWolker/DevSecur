<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->getUser()) {

            return $this->redirectToRoute('app_message');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route("/reset-password", name:"app_reset-password")]
    public function resetPassword(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ResetPasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userName = $form->get('nom')->getData();


            $sql = "SELECT * FROM [user] WHERE first_name = '" . $userName . "'";
            $user = $em->getConnection()->executeQuery($sql)->fetchAllAssociative();


            $this->addFlash('success', 'Un email de réinitialisation de mot de passe a été envoyé à votre adresse email.');


            return $this->redirectToRoute('app_reset-password-confirmation');
        }

        return $this->render('security/reset_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/reset-password/confirmation", name:"app_reset-password-confirmation")]
    public function resetPasswordConfirmation(EntityManagerInterface $em): Response
    {
        return $this->render('security/reset-password-confirmation.html.twig', [
            'users' => $em->getRepository(User::class)->findAll()
        ]);

    }
}
