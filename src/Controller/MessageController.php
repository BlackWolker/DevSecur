<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // Récupérer tous les messages (peut-être par ordre chronologique)
        $messages = $em->getRepository(Message::class)->findAll();

        // Créer un nouveau formulaire de message pour le salon de discussion
        $message = new Message();
        $salonForm = $this->createForm(MessageType::class, $message);
        $salonForm->handleRequest($request);

        if ($salonForm->isSubmitted() && $salonForm->isValid()) {
            // Ajouter l'utilisateur actuel comme auteur du message
            $message->setCustomer($this->getUser());
            // Enregistrer le nouveau message
            $title = $message->getTitle();
            $message->setTitle($title);

            $text = $message->getText();
            $message->setText($text);

            $em->persist($message);
            $em->flush();
            // Rediriger pour éviter la répétition du formulaire sur rechargement de la page
            return $this->redirectToRoute('app_message');
        }

        // Créer le formulaire de réservation
        $reservationForm = $this->createForm(MessageType::class);

        return $this->render('message/index.html.twig', [
            'messages' => $messages,
            'salonForm' => $salonForm->createView(),
            'form' => $reservationForm->createView(),
        ]);
    }
}
