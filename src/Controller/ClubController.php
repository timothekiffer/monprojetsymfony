<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function liste(ClubRepository $clubRepository): Response
    {
        $clubs = $clubRepository->findAll();

        return $this->render('club/liste.html.twig', [
            'clubs' => $clubs,
        ]);
    }

    #[Route('/club/{id}', name: 'app_club_detail')]
    public function detail(ClubRepository $clubRepository, int $id): Response
    {
        $club = $clubRepository->find($id);

        if (!$club) {
            throw $this->createNotFoundException('Club non trouvé');
        }

        return $this->render('club/detail.html.twig', [
            'club' => $club,
        ]);
    }

    #[Route('/club/{id}/joueurs', name: 'app_club_joueurs')]
    public function joueurs(ClubRepository $clubRepository, int $id, int $page = 1): Response
    {
        $club = $clubRepository->find($id);

        if (!$club) {
            throw $this->createNotFoundException('Club non trouvé');
        }

        $joueurs = $club->getJoueurs();

        return $this->render('club/joueurs.html.twig', [
            'club' => $club,
            'joueurs' => $joueurs,
        ]);
    }
}