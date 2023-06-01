<?php

namespace App\Form;

use App\Entity\Joueur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class NewJoueurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez un nom de joueur',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Le nom du joueur doit avoir au minimum {{ limit }} caractère',
                        'max' => 25,
                        'maxMessage' => 'Le nom du joueur doit avoir au maximum {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZàâäãéèêëïîóôöùûüÿçÀÂÄÃÇÉÈÊËÏÎÑñÔÖÙÜÛŸ\'\s]+$/u',
                        'message' => 'Le nom du joueur ne doit contenir que des lettres, des espaces ou des apostrophes.',
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
            ])
            ->add('age', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez un âge',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'L\'âge ne peut pas faire moins de {{ limit }} caractère',
                        'max' => 2,
                        'maxMessage' => 'L\'âge ne peut pas faire plus de {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]+$/u',
                        'message' => 'L\'âge ne doit contenir que des chiffres positifs.',
                    ]),
                ],
            ])
            ->add('photo', FileType::class, [
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/png'],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier PNG valide.',
                    ]),
                ],
            ])
            ->add('club')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joueur::class,
        ]);
    }
}
