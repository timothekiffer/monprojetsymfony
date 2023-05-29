<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassementController extends AbstractController
{
    #[Route('/classement', name: 'app_classement')]
    public function liste(ClubRepository $clubRepository): Response
    {
        $clubs = $clubRepository->findBy([], ['points' => 'DESC']);
        $nombreClubs = count($clubs);

        return $this->render('classement/tableau.html.twig', [
            'clubs' => $clubs,
            'nombreClubs' => $nombreClubs
        ]);
    }
}
