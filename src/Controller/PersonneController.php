<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\Ville;
use App\Entity\Voiture;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController {
    /**
     * @Route("/listePersonne", name="listePersonne")
     */
    public function listePersonne(Request $request){
        //recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $personneRepository=$em->getRepository(Personne::class);
        //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listePersonnes=$personneRepository->findAll();

        $resultat=[];
		foreach($listePersonnes as $pers){
			array_push($resultat,[$pers->getId()=>$pers->getPrenom()]);
		}

		$reponse=new JsonResponse($resultat);
        return $reponse;
    }

    /**
     * @Route("/insertPersonne/{nom}/{prenom}/{dateNaiss}/{villeId}/{tel}/{email}/{voitureId}/{userId}", name="insertPersonne", requirements={"nom"="[a-zA-Z]+", "prenom"="[a-zA-Z]+", "dateNaiss"="[0-9]{4}-[0-9]{2}-[0-9]{2}", "villeId"="[0-9]+", "tel"="[0-9]{10}", "email"="[a-z0-9.-_]{2,}@[a-z]{2,}\.[a-z]{2,}", "voitureId"="[0-9]+", "userId"="[0-9]+"})
     */
    public function insertPersonne(Request $request, $nom, $prenom, $dateNaiss, $villeId, $tel, $email, $voitureId, $userId) {
        $pers=new Personne();
        $pers->setNom($nom);
        $pers->setPrenom($prenom);
        $myDateTime = \DateTime::createFromFormat('Y-m-d', $dateNaiss);
        $pers->setDateNaiss($myDateTime);
        $pers->setTel($tel);
        $pers->setEmail($email);

        if($request->isMethod('get')) {
            // récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();

            // récupère la ville de la personne
            $villeRepository=$em->getRepository(Ville::class);
            $vil=$villeRepository->find($villeId);
            $pers->setVille($vil);

            // récupère la voiture de la personne
            $voitureRepository=$em->getRepository(Voiture::class);
            $voit=$voitureRepository->find($voitureId);
            $pers->setVoiture($voit);

            // récupère le user de la personne
            $userRepository=$em->getRepository(User::class);
            $us=$userRepository->find($userId);
            $pers->setUser($us);

            $em->persist($pers);
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
     * @Route("/deletePersonne/{id}", name="deletePersonne",requirements={"id"="[0-9]{1,5}"})
     */
    public function deletePersonne(Request $request, $id) {
        //récupération du Manager et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
        $personneRepository=$em->getRepository(Personne::class);
        //requete de selection
        $per=$personneRepository->find($id);
        //suppression de l'entity
        $em->remove($per);
        $em->flush();
        $resultat=["ok"];
        $reponse=new JsonResponse($resultat);
        return $reponse;
    }
}
