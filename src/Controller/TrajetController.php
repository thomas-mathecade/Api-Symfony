<?php

namespace App\Controller;
use App\Entity\Trajet;
use App\Entity\Personne;
use App\Entity\Ville;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrajetController extends AbstractController {
     /**
     * @Route("/listeTrajet", name="listeTrajet")
     */
    public function listeTrajet(Request $request) {
        //recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $trajetRepository=$em->getRepository(Trajet::class);
        //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeTrajet=$trajetRepository->findAll();
        $resultat=[];
		foreach($listeTrajet as $traj){
			array_push($resultat,[$traj->getId()]);
		}
		$reponse=new JsonResponse($resultat);
		
        return $reponse;
    }

    /**
     * @Route("/insertTrajet/{personneId}/{villeDepId}/{villeArrId}/{nbKms}/{dateTrajet}", name="insertTrajet", requirements={"personneId"="[0-9]{1,5}", "villeDepId"="[0-9]{1,5}", "villeArrId"="[0-9]{1,5}", "nbKms"="[0-9]+", "dateTrajet"="[0-9]{4}-[0-9]{2}-[0-9]{2}"})
     */
    public function insertTrajet(Request $request, $personneId, $villeDepId, $villeArrId, $nbKms, $dateTrajet) {
        $traj=new Trajet();
        $traj->setNbkms($nbKms);
        $myDateTime = \DateTime::createFromFormat('Y-m-d', $dateTrajet);
        $traj->setNbkms($myDateTime);

        if($request->isMethod('get')) {
            // récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();

            $personneRepository=$em->getRepository(Personne::class);
            $pers=$personneRepository->find($personneId);
            $traj->addPersonne()->add($pers);

            $villeRepository=$em->getRepository(Ville::class);
            $vilDep=$villeRepository->find($villeDepId);
            $traj->setVilleDep($vilDep);
            $vilArr=$villeRepository->find($villeArrId);
            $traj->setVilleArr($vilArr);

            $em->persist($traj);
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
     * @Route("/deleteTrajet/{id}", name="deleteTrajet",requirements={"id"="[0-9]{1,5}"})
     */
    public function deleteTrajet(Request $request, $id) {
        //récupération du Manager et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
        $trajetRepository=$em->getRepository(Trajet::class);
        //requete de selection
        $traj=$trajetRepository->find($id);
        //suppression de l'entity
        $em->remove($traj);
        $em->flush();
        $resultat=["ok"];
        $reponse=new JsonResponse($resultat);
        return $reponse;
    }
}
