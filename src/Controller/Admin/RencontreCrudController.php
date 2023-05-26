<?php

namespace App\Controller\Admin;

use App\Entity\Rencontre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RencontreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rencontre::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
