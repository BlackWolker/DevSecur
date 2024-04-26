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

        $messages = $em->getRepository(Message::class)->findAll();


        $message = new Message();
        $salonForm = $this->createForm(MessageType::class, $message);
        $salonForm->handleRequest($request);

        if ($salonForm->isSubmitted() && $salonForm->isValid()) {

            $message->setCustomer($this->getUser());

            $title = $message->getTitle();
            $message->setTitle($title);

            $text = $message->getText();
            $message->setText($text);

            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('app_message');
        }


        $reservationForm = $this->createForm(MessageType::class);

        return $this->render('message/index.html.twig', [
            'messages' => $messages,
            'salonForm' => $salonForm->createView(),
            'form' => $reservationForm->createView(),
        ]);
    }
}
