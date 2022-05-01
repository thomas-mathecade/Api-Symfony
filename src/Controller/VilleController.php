<?php

namespace App\Controller;

use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController {
    /**
     * @Route("/listeVille", name="listeVille")
     */
    public function listeVille(Request $request) {
        //recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $villeRepository=$em->getRepository(Ville::class);
        //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeVille=$villeRepository->findAll();
        $resultat=[];
		foreach($listeVille as $vil){
			array_push($resultat,[$vil->getId()=>$vil->getVille()]);
		}
		$reponse=new JsonResponse($resultat);
		
        return $reponse;
    }

    /**
     * @Route("/insertVille/{ville}/{codepostal}", name="insertVille", requirements={"ville"="[a-zA-Z]+", "codepostal"="[0-9]{5}"})
     */
    public function insertVille(Request $request, $ville, $codepostal) {
        $vil=new Ville();
        $vil->setVille($ville);
        $vil->setCodepostal($codepostal);

        if($request->isMethod('get')) {
            //récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();
            $em->persist($vil);
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
     * @Route("/deleteVille/{id}", name="deleteVille",requirements={"id"="[0-9]{1,5}"})
     */
    public function deleteVille(Request $request, $id) {
        //récupération du Manager et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
        $villeRepository=$em->getRepository(Ville::class);
        //requete de selection
        $vil=$villeRepository->find($id);
        //suppression de l'entity
        $em->remove($vil);
        $em->flush();
        $resultat=["ok"];
        $reponse=new JsonResponse($resultat);
        return $reponse;
    }
}
