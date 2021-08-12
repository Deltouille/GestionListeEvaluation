<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Liste;
use App\Entity\Tache;
use App\Form\ListeType;

class ListeController extends AbstractController
{
    /**
     * @Route("/listes", name="listes")
     */
    public function index(): Response
    {
        //On récupere l'entity manager
        $em = $this->getDoctrine()->getManager();
        //On récupere le repository de la classe Liste
        $listeRepository = $em->getRepository(Liste::class);
        //On récupere toutes les listes présentes dans la base de données
        $listeListe = $listeRepository->findAll();
        //On affiche toutes les listes
        return $this->render('liste/index.html.twig', [
            'listeListe' => $listeListe,
        ]);
    }

    /**
     * @Route("/listes-details/{id}", name="listes-details")
     */
    public function Read(int $id){
        //On récupere l'entity manager
        $em = $this->getDoctrine()->getManager();
        //On récupere le repository de la classe Liste
        $listeRepository = $em->getRepository(Liste::class);
        //On récupere la liste séléctionnée 
        $listeDetails = $listeRepository->find($id);
        //dd($listeDetails);
        //On affiche la page du détails de l'agent
        return $this->render('liste/details.html.twig', [
            'listeDetails' => $listeDetails,
        ]);

    }

    /**
     * @Route("/liste-ajout", name="liste-ajout")
     */
    public function Create(Request $request){
        //On créer une nouvelle liste
        $liste = new Liste();
        //On créer un nouveau formulaire
        $form = $this->createForm(ListeType::class, $liste);
        //On regarde si le formulaire a été envoyé avec une méthode POST
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            //On vérifie que le formulaire a bien été envoyé et qu'il est valide
            if($form->isSubmitted() && $form->isValid()){
                //On récupere l'entity manager
                $em = $this->getDoctrine()->getManager();
                //On enregistre la nouvelle liste dans la base de données
                $em->persist($liste);
                $em->flush();
                //On redirige sur la page qui affiche toutes les listes
                return $this->redirectToRoute('listes');
            }
        }
        //On affiche la page d'ajout d'une liste
        return $this->render('liste/ajoutListe.html.twig', [
            'liste' => $liste,
            'form' => $form->createView(),
        ]);
    }

    public function Update(){

    }

    /**
     * @Route("/liste-suppression/{id}", name="liste-suppression")
     * @Method({"DELETE"})
     */
    public function Delete(Request $request, int $id){
       //On récupere l'entity manager
       $em = $this->getDoctrine()->getManager();
       //On récupere le repository de la classe Liste
       $listeRepository = $em->getRepository(Liste::class);
       //On récupere la liste séléctionnée 
       $listeDetails = $listeRepository->find($id);

       //On récupere l'entity manager
       $em = $this->getDoctrine()->getManager();
       //On enregistre la nouvelle liste dans la base de données
       $em->remove($liste);
       $em->flush();

    }
}
