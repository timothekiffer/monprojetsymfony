<?php

namespace App\Form;

use App\Entity\Club;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class NewClubFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez un nom de club',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Le nom du club doit avoir au minimum {{ limit }} caractère',
                        'max' => 25,
                        'maxMessage' => 'Le nom du club doit avoir au maximum {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9àâäãéèêëïîóôöùûüÿçÀÂÄÃÇÉÈÊËÏÎÑñÔÖÙÜÛŸ\'\s]+$/u',
                        'message' => 'Le nom du club ne doit contenir que des lettres, des chiffres, des espaces ou des apostrophes.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr' => [
                    'class' => 'control-label',
                ],
            ])
            ->add('ville', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez un nom de ville',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Le nom de la ville doit avoir au minimum {{ limit }} caractère',
                        'max' => 25,
                        'maxMessage' => 'Le nom de la ville doit avoir au maximum {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Z][a-zA-ZàâäãéèêëïîóôöùûüÿçÀÂÄÃÇÉÈÊËÏÎÑñÔÖÙÜÛŸ\'\s]+$/u',
                        'message' => 'Le nom de la ville doit commencer par une majuscule et ne doit contenir que des lettres, des tirets, des espaces ou des apostrophes.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr' => [
                    'class' => 'control-label',
                ],
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez une description',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'La description doit avoir au minimum {{ limit }} caractère',
                        'max' => 500,
                        'maxMessage' => 'La description doit avoir au maximum {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9àâäãéèêëïîóôöùûüÿçÀÂÄÃÇÉÈÊËÏÎÑñÔÖÙÜÛŸ?!+-.,;:%€\'\s]+$/u',
                        'message' => 'La description ne doit contenir que des lettres, des chiffres, des espaces ou quelques caractères spéciaux.',
                    ]),
                ],
                'attr' => [
                    'rows' => 5,
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'form-group',
                ],
                'label_attr' => [
                    'class' => 'control-label',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Club::class,
        ]);
    }
}
