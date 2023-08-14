<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use App\Repository\EleveRepository;
use App\Repository\FormationRepository;
use App\Repository\ModuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig');
    }

    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('app/register.html.twig');
    }

    #[Route('/eleve/profil', name: 'profil_eleve')]
    public function profilEleve(EleveRepository $repo): Response
    {
        $id = $this->getUser('id');
        $eleve = $repo->find($id);
        $suivre = $eleve->getSuivres();
        dump($suivre);
        return $this->render('app/profilEleve.html.twig', [
            'suivre' => $suivre
        ]);
    }

    #[Route('/formateur/profil', name: 'profil_formateur')]
    public function profilFormateur(): Response
    {
        return $this->render('app/profilFormateur.html.twig');
    }

    #[Route('/eleve/formation/{id}', name: 'vue_formation_eleve')]
    public function vueFormation($id, EleveRepository $repoEleve, FormationRepository $repoFormation): Response
    {
        $userId = $this->getUser('id');
        $eleve = $repoEleve->find($userId);
        $suivre = $eleve->getSuivres();
        $formation = $repoFormation->find($id);
        $modules = $formation->getModules();
        return $this->render('app/vueFormation.html.twig', [
            'modules' => $modules,
            'formation' => $formation,
            'suivre' => $suivre,
        ]);
    }

    #[Route('/eleve/module/{id}', name: 'vue_module_eleve')]
    public function vueModule($id, EleveRepository $repoEleve, FormationRepository $repoFormation, ModuleRepository $repoModule): Response
    {
        $userId = $this->getUser('id');
        $eleve = $repoEleve->find($userId);
        $suivre = $eleve->getSuivres();
        $modulePage = $repoModule->find($id);
        $formation = $repoFormation->find($modulePage->getIdFor());
        $modules = $formation->getModules();
        $cours = $modulePage->getCours();
        return $this->render('app/vueModule.html.twig', [
            'modules' => $modules,
            'formation' => $formation,
            'suivre' => $suivre,
            'modulePage' => $modulePage,
            'cours' => $cours,
        ]);
    }

    #[Route('/eleve/cours/{id}', name: 'vue_cours_eleve')]
    public function vueCoursEleve($id, EleveRepository $repoEleve, FormationRepository $repoFormation, ModuleRepository $repoModule, CoursRepository $repoCours): Response
    {
        $coursPage = $repoCours->find($id);
        $userId = $this->getUser('id');
        $eleve = $repoEleve->find($userId);
        $suivre = $eleve->getSuivres();
        $modulePage = $repoModule->find($id);
        $formation = $repoFormation->find($modulePage->getIdFor());
        $modules = $formation->getModules();
        $cours = $modulePage->getCours();
        return $this->render('app/vueCours.html.twig', [
            'modules' => $modules,
            'formation' => $formation,
            'suivre' => $suivre,
            'modulePage' => $modulePage,
            'cours' => $cours,
            'coursPage' => $coursPage
        ]);
    }

    #[Route('/formations', name: 'formations')]
    public function formations(FormationRepository $repo): Response
    {
        $formations = $repo->findAll();
        return $this->render('app/formations.html.twig', [
            'formations' => $formations,
        ]);
    }

}
