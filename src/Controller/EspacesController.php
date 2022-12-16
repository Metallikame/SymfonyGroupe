<?php

namespace App\Controller;

use App\Entity\Espaces;
use App\Form\EspacesType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspacesController extends AbstractController
{
    /**
     * @Route("/", name="app_espaces_index")
     */
    public function index(ManagerRegistry $doctrine): Response
    {

        //On va aller chercher les espaces dans la BDD
        //pour ça on a besoin d'un repository
        $repo = $doctrine->getRepository(Espaces::class);
        $espaces=$repo->findAll(); //select * transformé en liste d'Espaces

        return $this->render('espaces/index.html.twig', [
            'espaces'=>$espaces
        ]);
    }

    /**
     * @Route("/espaces/ajouter", name="app_espaces_ajouter")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        //créer le formulaire
        //on crée d'abord un espace vide
        $espaces=new Espaces();
        //à partir de ça je crée le formulaire
        $form=$this->createForm(EspacesType::class, $espaces);

        //On gère le retour du formulaire tout de suite
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            //l'objet espaces est rempli
            //on va utiliser l'entity manager de doctrine
            $em=$doctrine->getManager();
            //on lui dit qu'on veut mettre l'espace dans la table
            $em->persist($espaces);

            //on génère l'appel SQL (l'insert ici)
            $em->flush();

            //on revient à l'accueil
            return $this->redirectToRoute("app_espaces_index");
        }

        return $this->render("espaces/index.html.twig",[
            "formulaire"=>$form->createView()
        ]);
    }

    /**
     * @Route("/espaces/modifier/{id}", name="app_espaces_modifier")
     */
    public function modifier($id, ManagerRegistry $doctrine, Request $request): Response{
        //créer le formulaire sur le même principe que dans ajouter
        //mais avec un espace existant
        $espaces = $doctrine->getRepository(Espaces::class)->find($id);

        //je vais gérer le fait que l'id n'existe pas
        if (!$espaces){
            throw $this->createNotFoundException("Pas d'espace avec l'id $id");
        }

        //Si j'arrive là c'est qu'il existe en BDD
        //à partir de ça je crée le formulaire
        $form=$this->createForm(EspacesType::class, $espaces);

        //On gère le retour du formulaire tout de suite
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            //l'objet espaces est rempli
            //on va utiliser l'entity manager de doctrine
            $em=$doctrine->getManager();
            //on lui dit qu'on veut mettre l'espace dans la table
            $em->persist($espaces);

            //on génère l'appel SQL (update ici)
            $em->flush();

            //on revient à l'accueil
            return $this->redirectToRoute("app_espaces");
        }

        return $this->render("espaces/modifier.html.twig",[
            "espaces"=>$espaces,
            "formulaire"=>$form->createView()
        ]);
    }
}
