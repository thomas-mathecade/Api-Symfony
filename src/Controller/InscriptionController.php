<?php

namespace App\Controller;
use App\Entity\Inscription;
use App\Entity\Trajet;
use App\Entity\Personne;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/listeInscription", name="listeInscription")
     */
    public function listeInscription(Request $request){
        //recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $inscriptionRepository=$em->getRepository(Inscription::class);
        //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeInscription=$inscriptionRepository->findAll();
        $resultat=[];
		foreach($listeInscription as $insc){
			array_push($resultat,[$insc->getId()]);
		}
		$reponse=new JsonResponse($resultat);
		
		
        return $reponse;
    }

    /**
     * @Route("/insertInscription/{personneId}/{trajetId}", name="insertInscription", requirements={"personneId"="[0-9]{1,5}", "trajetId"="[0-9]{1,5}"})
     */
    public function insertInscription(Request $request, $personneId, $trajetId) {
        $insc=new Inscription();

        if($request->isMethod('get')) {
            //récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();

            $personneRepository=$em->getRepository(Personne::class);
            $pers=$personneRepository->find($personneId);
            $insc->addPersonne()->add($pers);

            $trajetRepository=$em->getRepository(Trajet::class);
            $traj=$trajetRepository->find($trajetId);
            $insc->addTrajet()->add($traj);

            $em->persist($insc);
            //insertion en bdd
            $em->flush();
            $resultat=["ok"];
        } else {
            $resultat=["nok"];
        }

        $reponse=new JsonResponse($resultat);
        return $reponse;
    }

    /**
     * @Route("/deleteInscription/{id}", name="deleteInscription",requirements={"id"="[0-9]{1,5}"})
     */
    public function deleteInscription(Request $request, $id) {
        //récupération du Manager et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
        $inscriptionRepository=$em->getRepository(Inscription::class);
        //requete de selection
        $insc=$inscriptionRepository->find($id);
        //suppression de l'entity
        $em->remove($insc);
        $em->flush();
        $resultat=["ok"];
        $reponse=new JsonResponse($resultat);
        return $reponse;
    }
}
