<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ContactController extends AbstractController
{
    /**
     * @Route("/send-message", name="send_message", methods={"POST"})
     */
    public function sendMessage(Request $request, MailerInterface $mailer, ValidatorInterface $validator): Response
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $message = $request->request->get('message');

        // Valider les données
        $violations = $validator->validate(
            compact('name', 'email', 'message'),
            new Assert\Collection([
                'name' => [new Assert\NotBlank(), new Assert\Length(['max' => 255])],
                'email' => [new Assert\NotBlank(), new Assert\Email()],
                'message' => [new Assert\NotBlank(), new Assert\Length(['max' => 2000])],
            ])
        );

        if (count($violations) > 0) {
            return $this->render('contact/contacts.html.twig', [
                'errors' => $violations,
                'old_data' => compact('name', 'email', 'message'),
            ]);
        }

        // Préparer et envoyer l'email
        $emailMessage = (new Email())
            ->from('creeper.psg.78@gmail.com') // Remplacez par votre adresse Gmail
            ->to('nene.almeida78@gmail.com') // Adresse du destinataire
            ->subject('Nouveau message depuis le formulaire de contact')
            ->text("Nom: $name\nEmail: $email\nMessage:\n$message");

        $mailer->send($emailMessage);

        $this->addFlash('success', 'Votre message a été envoyé avec succès !');

        return $this->redirectToRoute('contacts');
    }
}
