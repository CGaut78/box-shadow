<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\Module;
use App\Entity\Commande;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Controller\Admin\AdminCrudController;
use App\Entity\Suivre;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(AdminCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Box Shadow');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard("Back Office", 'fa fa-igloo'),
            MenuItem::section('Profils'),
            MenuItem::linkToCrud('Admin', 'fas fa-code', Admin::class),
            MenuItem::linkToCrud('Eleve', 'fas fa-user', Eleve::class),
            MenuItem::linkToCrud('Formateur', 'fas fa-chalkboard-user', Formateur::class),
            MenuItem::section('Contenu'),
            MenuItem::linkToCrud('Formation', 'fas fa-sliders', Formation::class),
            MenuItem::linkToCrud('Module', 'fas fa-sliders', Module::class),
            MenuItem::linkToCrud('Cours', 'fas fa-sliders', Cours::class),
            MenuItem::section('Commandes'),
            MenuItem::linkToCrud('Commande', 'fas fa-sliders', Commande::class),
            MenuItem::linkToCrud('Suivre', 'fas fa-sliders', Suivre::class),
            MenuItem::section('Site'),
            MenuItem::linkToRoute('Retourner sur le site', 'fa fa-home', 'home'),
        ];
    }
}
