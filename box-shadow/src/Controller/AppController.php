<?php

namespace App\Controller;

use App\Repository\EleveRepository;
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

}
