<?php

namespace App\Controller;

use App\Form\ModifClubFormType;
use App\Repository\ClubRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

    #[IsGranted("ROLE_LIGUE")] // accessible seulement pour les utilisateurs ayant le rôle ROLE_LIGUE
    #[Route('/club/{id}/modif', name: 'app_club_modif')]
    public function modifier(Request $request, EntityManagerInterface $manager, ClubRepository $clubRepository, int $id): Response
    {
        $club = $clubRepository->find($id);

        if (!$club) {
            throw $this->createNotFoundException('Club non trouvé');
        }

        $form = $this->createForm(ModifClubFormType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $club->setDateModification(new DateTime('now'));

            $manager->persist($club);
            $manager->flush();

            $this->addFlash('success', 'Le club a été modifié avec succès.');
            return $this->redirectToRoute('app_club_detail', ['id' => $id]);
        }

        return $this->render('club/modif.html.twig', [
            'ModifClubForm' => $form->createView(),
            'club' => $club
        ]);
    }

    
    #[Route('/club/supprimer/{id}', name:'app_club_supprimer')]
    
    public function supprimer(int $id, EntityManagerInterface $manager, ClubRepository $clubRepository): Response
    {
        $club = $clubRepository->find($id);

        if (!$club) {
            throw $this->createNotFoundException('Club non trouvé.');
        }

        $manager->remove($club);
        $manager->flush();
        
        $this->addFlash('success', 'Le club a été supprimé avec succès.');
        return $this->redirectToRoute('app_club');
    }
}