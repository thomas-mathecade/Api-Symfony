<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Marque;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController {
   /**
     * @Route("/listeVoiture", name="listeVoiture")
     */
    public function listeVoiture(Request $request) {
        //recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $voitureRepository=$em->getRepository(Voiture::class);
        //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeVoiture=$voitureRepository->findAll();
        $resultat=[];
		foreach($listeVoiture as $voit){
			array_push($resultat,[$voit->getId()=>$voit->getModele()]);
		}
		$reponse=new JsonResponse($resultat);
		
        return $reponse;
    }

    /**
     * @Route("/insertVoiture/{marqueId}/{nb_place}/{modele}", name="insertVoiture", requirements={"marqueId"="[0-9]+", "nb_place"="[1-5]{1}", "modele"="[a-zA-Z0-9]+"})
     */
    public function insertVoiture(Request $request, $marqueId, $nb_place, $modele) {
        $voit=new Voiture();
        $voit->setNbPlace($nb_place);
        $voit->setModele($modele);

        if($request->isMethod('get')) {
            // récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();

            // récupère la marque de la voiture
            $marqueRepository=$em->getRepository(Marque::class);
            $marq=$marqueRepository->find($marqueId);
            $voit->setMarque($marq);

            $em->persist($voit);
            // insertion en bdd
            $em->flush();
            $resultat=["ok"];
        } else {
            $resultat=["nok"];
        }

        $reponse=new JsonResponse($resultat);
        return $reponse;
    }

    /**
     * @Route("/deleteVoiture/{id}", name="deleteVoiture",requirements={"id"="[0-9]{1,5}"})
     */
    public function deleteVoiture(Request $request, $id) {
        //récupération du Manager et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
        $voitureRepository=$em->getRepository(Voiture::class);
        //requete de selection
        $voit=$voitureRepository->find($id);
        //suppression de l'entity
        $em->remove($voit);
        $em->flush();
        $resultat=["ok"];
        $reponse=new JsonResponse($resultat);
        return $reponse;
    }
}
