<?php

namespace App\Controller\Admin;

use App\Entity\Formateur;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FormateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Formateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            TextField::new('prenom', 'Prénom'),
            TextField::new('nom', 'Nom'),
            TextField::new('password', 'Mot de passe')->setFormType(PasswordType::class)->onlyWhenCreating(),
            TextField::new('numero_carte', 'N° carte'),
            DateField::new('date_expiration', 'Date expiration'),
            TextField::new('code_carte', 'Code'),
            CollectionField::new('roles')->setTemplatePath('fields/roles.html.twig'),
        ];
    }
}
