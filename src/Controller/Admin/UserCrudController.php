<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('Users')
            ->setSearchFields(['nom', 'prenom', 'email'])
            ->setDefaultSort(['date_creation' => 'DESC'])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = $this->getRoleChoices();

        yield TextField::new('email');
        yield TextField::new('nom');
        yield TextField::new('prenom');
        yield ChoiceField::new('roles')->setChoices($roles)->allowMultipleChoices()->renderAsBadges();
        yield BooleanField::new('actif');
        yield DateTimeField::new('date_creation');
        yield DateTimeField::new('date_modification');
    }

    private function getRoleChoices(): array
    {
        $roles = [
            'ROLE_ADMIN' => 'ROLE_ADMIN',
            'ROLE_LIGUE' => 'ROLE_LIGUE',
            'ROLE_CLUB'  => 'ROLE_CLUB',
            'ROLE_USER'  => 'ROLE_USER',
        ];
        return $roles;
    }
}
