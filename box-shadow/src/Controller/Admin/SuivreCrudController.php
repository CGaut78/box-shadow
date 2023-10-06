<?php

namespace App\Controller\Admin;

use App\Entity\Suivre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SuivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Suivre::class;
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
