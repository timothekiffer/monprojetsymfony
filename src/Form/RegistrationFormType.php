<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez un nom',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Votre nom doit avoir au minimum {{ limit }} caractère',
                        'max' => 25,
                        'maxMessage' => 'Votre nom doit avoir au maximum {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZàâäãéèêëïîóôöùûüÿçÀÂÄÃÇÉÈÊËÏÎÑñÔÖÙÜÛŸ\'\s]+$/u',
                        'message' => 'Le nom ne doit contenir que des lettres, des espaces ou des apostrophes.',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez un prénom',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Votre prénom doit avoir au minimum {{ limit }} caractère',
                        'max' => 25,
                        'maxMessage' => 'Votre prénom doit avoir au maximum {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9àâäãéèêëïîóôöùûüÿçÀÂÄÃÇÉÈÊËÏÎÑñÔÖÙÜÛŸ\'\s]+$/u',
                        'message' => 'Le prénom ne doit contenir que des lettres, des chiffres, des espaces ou des apostrophes.',
                    ]),
                ],
                'label' => 'Prénom',
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez un email',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Votre prénom doit avoir au minimum {{ limit }} caractère',
                        'max' => 50,
                        'maxMessage' => 'Votre prénom doit avoir au maximum {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-z0-9@.\s]+$/u',
                        'message' => 'Le mail ne doit contenir que des lettres, des chiffres ou des points.',
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les termes d\'utilisation',
                    ]),
                ],
                'label' => 'Acceptez les termes',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation du mot de passe'],
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
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}