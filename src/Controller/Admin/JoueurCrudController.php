<?php

namespace App\Controller\Admin;

use App\Entity\Joueur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class JoueurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Joueur::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Joueur')
            ->setEntityLabelInPlural('Joueurs')
            ->setSearchFields(['nom', 'prenom', 'age', 'blesse'])
            ->setDefaultSort(['date_creation' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('club'))
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('club');
        yield TextField::new('nom');
        yield TextField::new('prenom');
        yield IntegerField::new('age');
        yield ImageField::new('photo')->setUploadDir('public/images/')->hideOnIndex();
        yield BooleanField::new('blesse');
        yield BooleanField::new('actif');
        yield DateTimeField::new('date_creation');
        yield DateTimeField::new('date_modification');
        /*yield DateTimeField::new('date_creation')->setFormTypeOptions([
            'years' => range(1850, date('Y')),
            'widget' => 'single_text'
        ]);*/
    }
    
}