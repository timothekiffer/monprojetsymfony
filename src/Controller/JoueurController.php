<?php

namespace App\Controller;

use App\Repository\JoueurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JoueurController extends AbstractController
{
    #[Route('/joueur', name: 'app_joueur')]
    public function liste(JoueurRepository $joueurRepository): Response
    {
        $joueurs = $joueurRepository->findAll();

        return $this->render('joueur/liste.html.twig', [
            'joueurs' => $joueurs,
        ]);
    }
}