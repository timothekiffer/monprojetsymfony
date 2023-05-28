<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[IsGranted("IS_AUTHENTICATED_FULLY")] // accessible seulement pour les utilisateurs connectés
    #[Route('/changepassword', name: 'app_change_password')]
    public function changepassword(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // récupère l'utilisateur connecté sous forme d'objet
        $user = $this->getUser();

        // crée un formulaire avec un champs plainPwd répété 2 fois
        $form = $this->createFormBuilder()->add('plainPwd', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe ne correspondent pas',
            'required' => false,
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrez un mot de passe',
                ]),
                new NotCompromisedPassword([
                    'message' => 'Votre mot de passe est compromis dans des bases de données publiques'
                ]),
                new Length([
                    'min' => 8,
                    'minMessage' => 'Votre mot de passe doit avoir au minimum {{ limit }} caractères',
                    'max' => 50,
                    'maxMessage' => 'Votre mot de passe doit avoir au maximum {{ limit }} caractères',
                ]),
                new Regex([
                    'pattern' => '/\d+/i',
                    'message' => 'Votre mot de passe doit contenir au moins un chiffre',
                ]),
                new Regex([
                    'pattern' => '/[#?!@$%^&*-]+/i',
                    'message' => 'Votre mot de passe doit contenir au moins un caractère spécial #?!@$%^&*-',
                ]),
                new Regex([
                    'pattern' => '/[abcdefghijklmnopqrstuvwxyz]+/',
                    'message' => 'Votre mot de passe doit contenir au moins un caractère en miniscule',
                ]),
                new Regex([
                    'pattern' => '/[ABCDEFGHIJKLMNOPQRSTUVWXYZ]+/',
                    'message' => 'Votre mot de passe doit contenir au moins un caractère en majuscule',
                ]),
            ]
        ])->getForm();

        // gère le traitement de la saisie du formulaire
        $form->handleRequest($request);

        // vérifie si le formulaire a été soumis par l'utilisateur et s'il répond aux différentes contraintes de validation
        if ($form->isSubmitted() && $form->isValid()) {

            // récupère la valeur du champs plainPwd rentrée par l'utilisateur
            // cette valeur est stockée en clair
            $plainPwd = $form['plainPwd']->getData();
            
            // hache la valeur de plainPwd
            // puis stocke la valeur en tant que nouveau mot de passe de l'utilisateur
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $plainPwd
                )
            );
            
            // informe Doctrine que l'on veut ajouter l'objet $user à la BDD (c'est-à-dire modifier l'utilisateur existant)
            $manager->persist($user);
            
            // exécute la requête qui modifie la BDD
            $manager->flush();

            // Affiche un message indiquant la modification
            // et redirige vers la page de profil
            $this->addFlash('success', 'Votre mot de passe a été modifié avec succès.');
            return $this->redirectToRoute('app_profil');
        }

        // retourne la Vue avec le formulaire
        return $this->render('security/changepassword.html.twig', [
            'email' => $user->getEmail(),
            'form' => $form->createView()
        ]);
    }
}
