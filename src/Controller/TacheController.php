<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tache;
use App\Form\TacheType;

class TacheController extends AbstractController
{
    /**
     * @Route("/tache", name="tache")
     */
    public function index(): Response
    {
       //On récupere l'entity manager
       $em = $this->getDoctrine()->getManager();
       //On récupere le repository de la classe Tache
       $tacheRepository = $em->getRepository(Tache::class);
       //On récupere toutes les taches présentes dans la base de données
       $listeTache = $tacheRepository->findAll();
       //On affiche toutes les taches
       return $this->render('tache/index.html.twig', [
           'listeTache' => $listeTache,
       ]);
    }

    /**
     * @Route("/tache-details/{id}", name="tache-details")
     */
    public function Read(int $id){
        //On récupere l'entity manager
        $em = $this->getDoctrine()->getManager();
        //On récupere le repository de la classe Tache
        $tacheRepository = $em->getRepository(Tache::class);
        //On récupere la tache séléctionnée 
        $tacheDetails = $tacheRepository->find($id);
        //On verifie que la tache existe
        if($tacheDetails === null){
            return $this->redirectToRoute('redirection-tache');
        }
        //On affiche la page du détails de la tache
        return $this->render('tache/details.html.twig', [
            'tacheDetails' => $tacheDetails,
        ]);
    }

    /**
     * @Route("/tache-ajout", name="tache-ajout")
     */
    public function Create(Request $request){
        //On créer une nouvelle tache
        $tache = new Tache();
        //On créer un nouveau formulaire
        $form = $this->createForm(TacheType::class, $tache);
        //On regarde si le formulaire a été envoyé avec une méthode POST
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            //On vérifie que le formulaire a bien été envoyé et qu'il est valide
            if($form->isSubmitted() && $form->isValid()){
                //On récupere l'entity manager
                $em = $this->getDoctrine()->getManager();
                //On enregistre la nouvelle tache dans la base de données
                $em->persist($tache);
                $em->flush();
                //On redirige sur la page qui affiche toutes les taches
                return $this->redirectToRoute('listes-details', ['id' => $tache->getListe()->getId()]);
            }
        }
        //On affiche la page d'ajout d'une tache
        return $this->render('tache/ajoutTache.html.twig', [
            'tache' => $tache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tache-modification/{id}", name="tache-modification")
     */
    public function Update(Request $request, int $id){
        //On récupere l'entity manager
        $em = $this->getDoctrine()->getManager();
        //On récupere le repository de la classe Tache
        $tacheRepository = $em->getRepository(Tache::class);
        //On récupere la tache séléctionnée 
        $tacheModification = $tacheRepository->find($id);
        //On verifie que la tache existe
        if($tacheModification === null){
            return $this->redirectToRoute('redirection-tache');
        }
        //On créer un nouveau formulaire
        $form = $this->createForm(TacheType::class, $tacheModification);
        //On regarde si le formulaire a été envoyé avec une méthode POST
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            //On vérifie que le formulaire a bien été envoyé et qu'il est valide
            if($form->isSubmitted() && $form->isValid()){
                //On enregistre la nouvelle tache dans la base de données
                $em->persist($tacheModification);
                $em->flush();
                //On redirige sur la page qui affiche toutes les taches
                return $this->redirectToRoute('listes-details', ['id' => $tacheModification->getListe()->getId()]);
            }
        }
        //On affiche la page d'ajout d'une tache
        return $this->render('tache/modificationTache.html.twig', [
            'tacheModification' => $tacheModification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tache-suppression/{id}", name="tache-suppression")
     */
    public function Delete(int $id){
        //On récupere l'entity manager
        $em = $this->getDoctrine()->getManager();
        //On récupere le repository de la classe Tache
        $tacheRepository = $em->getRepository(Tache::class);
        //On récupere la liste séléctionnée 
        $tacheSuppression = $tacheRepository->find($id);
        //On verifie que la tache existe
        if($tacheSuppression === null){
            return $this->redirectToRoute('redirection-tache');
        }
        //On supprime la tache de la base de données
        $em->remove($tacheSuppression);
        $em->flush();

        return $this->redirectToRoute('listes-details', ['id' => $tacheSuppression->getListe()->getId()]);
    }

    /**
     * @Route("/tache-modification-statut/{id}", name="tache-modification-statut")
     */
    public function updateStatut(Request $request, int $id){
        //On récupere l'entity manager
        $em = $this->getDoctrine()->getManager();
        //On récupere le repository de la classe Tache
        $tacheRepository = $em->getRepository(Tache::class);
        //On récupere la liste séléctionnée 
        $tacheModificationStatut = $tacheRepository->find($id);
        //On verifie que la tache existe
        if($tacheModificationStatut === null){
            return $this->redirectToRoute('redirection-tache');
        }
        //On update le champ statut
        $tacheModificationStatut->setStatut($_POST['statut']);
        //On persist dans la base de données
        $em->persist($tacheModificationStatut);
        $em->flush();
        //On redirige sur la page qui affiche toutes les taches
        return $this->redirectToRoute('listes-details', ['id' => $tacheModificationStatut->getListe()->getId()]);
    }
    
    /**
     * @Route("/redirection-tache", name="redirection-tache")
     */
    public function redirection(){
        return $this->render('tache/erreurRedirection.html.twig');
    }
}
