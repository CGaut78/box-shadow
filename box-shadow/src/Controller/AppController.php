<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Formateur;
use App\Entity\Suivre;
use App\Form\CardType;
use App\Repository\CommandeRepository;
use App\Repository\CoursRepository;
use App\Repository\EleveRepository;
use App\Repository\ModuleRepository;
use App\Repository\FormateurRepository;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Query\AST\WhereClause;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function profilFormateur(FormateurRepository $repo): Response
    {
        $id = $this->getUser('id');
        $formateur = $repo->find($id);
        $commande = $formateur->getCommandes();
        return $this->render('app/profilFormateur.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/eleve/formation/{id}', name: 'vue_formation_eleve')]
    #[Route('/formateur/formation/{id}', name: 'vue_formation_formateur')]
    public function vueFormation($id, EleveRepository $repoEleve, FormateurRepository $repoFormateur, FormationRepository $repoFormation, CommandeRepository $repoCommande): Response
    {
        $userId = $this->getUser('id');
        $formation = $repoFormation->find($id);
        $modules = $formation->getModules();        
        if($this->isGranted('ROLE_FORMATEUR')){
            $formateur = $repoFormateur->find($userId);
            $commande = $formateur->getCommandes($id);
            return $this->render('app/vueFormation.html.twig', [
                'modules' => $modules,
                'formation' => $formation,
                'commande' => $commande,
            ]);
        } elseif($this->isGranted('ROLE_ELEVE')){
            $eleve = $repoEleve->find($userId);
            $suivre = $eleve->getSuivres();  
            return $this->render('app/vueFormation.html.twig', [
                'modules' => $modules,
                'formation' => $formation,
                'suivre' => $suivre,
            ]);              
        }
    }

    #[Route('/eleve/module/{id}', name: 'vue_module_eleve')]
    #[Route('/formateur/module/{id}', name: 'vue_module_formateur')]
    public function vueModule($id, EleveRepository $repoEleve, FormateurRepository $repoFormateur, FormationRepository $repoFormation, ModuleRepository $repoModule): Response
    {
        $userId = $this->getUser('id');
        $modulePage = $repoModule->find($id);
        $formation = $repoFormation->find($modulePage->getIdFor());
        $modules = $formation->getModules();
        $cours = $modulePage->getCours();        
        if($this->isGranted('ROLE_ELEVE')){
            $eleve = $repoEleve->find($userId);
            $suivre = $eleve->getSuivres();
            return $this->render('app/vueModule.html.twig', [
                'modules' => $modules,
                'formation' => $formation,
                'suivre' => $suivre,
                'modulePage' => $modulePage,
                'cours' => $cours,
            ]);            
        } elseif($this->isGranted('ROLE_FORMATEUR')){
            $formateur = $repoFormateur->find($userId);
            $commande = $formateur->getCommandes();
            return $this->render('app/vueModule.html.twig', [
                'modules' => $modules,
                'formation' => $formation,
                'commande' => $commande,
                'modulePage' => $modulePage,
                'cours' => $cours,
            ]);  
        }

    }

    #[Route('/eleve/cours/{id}', name: 'vue_cours_eleve')]
    #[Route('/formateur/cours/{id}', name: 'vue_cours_formateur')]
    public function vueCoursEleve($id, EleveRepository $repoEleve, FormateurRepository $repoFormateur, FormationRepository $repoFormation, ModuleRepository $repoModule, CoursRepository $repoCours): Response
    {
        $coursPage = $repoCours->find($id);
        $userId = $this->getUser('id');

        $modulePage = $repoModule->find($id);
        $formation = $repoFormation->find($modulePage->getIdFor());
        $modules = $formation->getModules();
        $cours = $modulePage->getCours();
        if($this->isGranted('ROLE_ELEVE')){
            $eleve = $repoEleve->find($userId);
            $suivre = $eleve->getSuivres();            
            return $this->render('app/vueCours.html.twig', [
                'modules' => $modules,
                'formation' => $formation,
                'suivre' => $suivre,
                'modulePage' => $modulePage,
                'cours' => $cours,
                'coursPage' => $coursPage
            ]);
        } elseif($this->isGranted('ROLE_FORMATEUR')){
            $formateur = $repoFormateur->find($userId);
            $commande = $formateur->getCommandes();
            return $this->render('app/vueCours.html.twig', [
                'modules' => $modules,
                'formation' => $formation,
                'commande' => $commande,
                'modulePage' => $modulePage,
                'cours' => $cours,
                'coursPage' => $coursPage
            ]);           
        }

    }

    #[Route('/formations', name: 'formations')]
    public function formations(FormationRepository $repoFormation, FormateurRepository $repoFormateur): Response
    {
        $formations = $repoFormation->findAll();
        $codesCommandes = [];
        if($this->isGranted('ROLE_FORMATEUR')){
            $userId = $this->getUser('id');
            $formateur = $repoFormateur->find($userId);
            $commandes = $formateur->getCommandes();
            foreach($commandes as $order){
                $code = $order->getIdFormation()->getId();
                array_push($codesCommandes, $code);
            }
        }
        return $this->render('app/formations.html.twig', [
            'formations' => $formations,
            'codesCommandes' => $codesCommandes,
        ]);
    }

    #[Route('/formateur/commande/{id}', name: 'commande')]
    public function commande($id, EntityManagerInterface $entityManager, FormationRepository $repoFormation, FormateurRepository $repoFormateur, CommandeRepository $repoCommande): Response
    {
        $userId = $this->getUser('id');
        $formateur = $repoFormateur->find($userId);
        if ($formateur->getCodeCarte() != null && $formateur->getNumeroCarte() != null && $formateur->getDateExpiration() != null){
            $formation = $repoFormation->find($id);
            $commande = new Commande();
            $commande->setIdFormation($formation);
            $commande->setIdFormateur($this->getUser('id'));
            function generateCode() {
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomString = '';
                for ($i = 0; $i < 8; $i++) {
                    $index = rand(0, strlen($characters) - 1);
                    $randomString .= $characters[$index];
                }
                return $randomString;
                }
            $code = generateCode();
            $allCommandes = $repoCommande->findAll();
            $allCodes = [];
            foreach($allCommandes as $order){
                $orderCode = $order->getCode();
                array_push($allCodes, $orderCode);
            }
            if(!in_array($code, $allCodes)){
                $commande->setCode($code);
            } else {
                $code = generateCode();
                $commande->setCode($code);
            }
            $entityManager->persist($commande);
            $entityManager->flush();
            return $this->redirectToRoute('profil_formateur');            
        } else {
            return $this->redirectToRoute('carte');            
        }      
    }

    #[Route('/formateur/register/success', name: 'success')]
    public function success(): Response
    {
        return $this->render('app/success.html.twig');
    }

    #[Route('/formateur/carte', name: 'carte')]
    public function carte(Request $request, EntityManagerInterface $entityManager, FormateurRepository $repo): Response
    {
        $userId = $this->getUser('id');
        $formateur = $repo->find($userId);
        $form = $this->createForm(CardType::class, $formateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($formateur);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('app/card.html.twig', [
            'cardForm' => $form->createView(),
        ]);
    }

    #[Route('/eleve/code', name: 'code')]
    public function code(Request $request, CommandeRepository $repoCommande, EntityManagerInterface $entityManager, EleveRepository $repoEleve): Response
    {
        $userId = $this->getUser('id');
        $code = $request->query->get('code');
        $allCommandes = $repoCommande->findAll();
        foreach($allCommandes as $commande){
            if($commande->getCode() == $code){
                $suivre = new Suivre;
                $suivre->setIdCommande($commande);
                $suivre->setIdEleve($userId);
                $entityManager->persist($suivre);
                $entityManager->flush();
                return $this->redirectToRoute('profil_eleve');
            }
        }
        return $this->render('app/code.html.twig');
    }

}
