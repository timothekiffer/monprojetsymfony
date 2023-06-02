<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Form\NewJoueurFormType;
use App\Repository\JoueurRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class JoueurController extends AbstractController
{
    #[Route('/joueur', name: 'app_joueur')]
    public function liste(JoueurRepository $joueurRepository): Response
    {
        $joueurs = $joueurRepository->findAll();

        return $this->render('joueur/liste.html.twig', [
            'joueurs' => $joueurs
        ]);
    }

    #[Route('/joueur2', name: 'app_joueur_liste2')]
    public function liste2(JoueurRepository $joueurRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $joueurRepository->paginationQuery(),
            $request->query->get('page', 1),
            4
        );

        return $this->render('joueur/liste2.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[IsGranted("ROLE_CLUB")]
    #[Route('/joueur/nouveau', name:'app_joueur_nouveau')]
    public function nouveau(Request $request, EntityManagerInterface $manager): Response
    {
        $joueur = new Joueur();

        $form = $this->createForm(NewJoueurFormType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $nom = $form->get('nom')->getData();
            $nom_majuscule = strtoupper($nom);
            $nom_fichier = str_replace(' ', '_', $nom_majuscule);
            $nom_fichier_complet = $nom_fichier.'.png';
            $photo = $form->get('photo')->getData();

            $destination = $this->getParameter('kernel.project_dir').'/public/images/joueurs/';

            if($photo){
                $photo->move($destination, $nom_fichier_complet);
            }

            $joueur->setActif(1);
            $joueur->setBlesse(0);
            $joueur->setPhoto($nom_fichier_complet);
            $joueur->setDateCreation(new DateTime('now'));
            $joueur->setDateModification(new DateTime('now'));

            $manager->persist($joueur);
            $manager->flush();
            
            $this->addFlash('success', 'Le Joueur a été ajouté avec succès.');
            return $this->redirectToRoute('app_joueur');
        }

        return $this->render('joueur/nouveau.html.twig', [
            'NewJoueurForm' => $form->createView(),
        ]);
    }
}