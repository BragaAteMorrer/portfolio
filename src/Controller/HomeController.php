<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
    #[Route('/a-propos-de-moi', name: 'quijesuis')]
    public function quijesuis(): Response
    {
        return $this->render('who/quijesuis.html.twig');
    }
    #[Route('/mes-competences', name: 'mescompetences')]
    public function competences(): Response
    {
        return $this->render('who/mescompetences.html.twig');
    }
    #[Route('/mes-creations', name: 'mescreations')]
    public function creations(): Response
    {
        return $this->render('who/mescreations.html.twig');
    }
    #[Route('/contacts', name: 'contacts')]
    public function contacts(): Response
    {
        return $this->render('contact/contacts.html.twig');
    }
}
