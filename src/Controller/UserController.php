<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {
    /**
     * @Route("/listeUser", name="listeUser")
     */
    public function listeUser(Request $request){
        //recuperation du repository grace au manager
        $em=$this->getDoctrine()->getManager();
        $userRepository=$em->getRepository(User::class);
        //personneRepository herite de servciceEntityRepository ayant les methodes pour recuperer les données de la bdd
        $listeUser=$userRepository->findAll();
        $resultat=[];
		foreach($listeUser as $us){
			array_push($resultat,[$us->getId()=>$us->getUsername()]);
		}
		$reponse=new JsonResponse($resultat);
		
		
        return $reponse;
    }

    /**
     * @Route("/insertUser/{username}/{password}/{role}", name="insertUser", requirements={"username"="[a-zA-Z0-9]{2,}", "password"="[a-zA-Z0-9_-]{2,}", "role"="ROLE_USER|ROLE_ADMIN"})
     */
    public function insertUser(Request $request, $username, $password, $role) {
        $us=new User();
        $us->setUsername($username);
        $us->setRoles([$role]);
        $pwd = password_hash($password, PASSWORD_DEFAULT);
        $us->setPassword($pwd);
        $randomApiToken = rand(100000, 999999);
        $us->setApiToken($randomApiToken);

        if($request->isMethod('get')) {
            //récupération de l'entityManager pour insérer les données en bdd
            $em=$this->getDoctrine()->getManager();
            $em->persist($us);
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
     * @Route("/deleteUser/{id}", name="deleteUser",requirements={"id"="[0-9]{1,5}"})
     */
    public function deleteUser(Request $request, $id) {
        //récupération du Manager et du repository pour accéder à la bdd
        $em=$this->getDoctrine()->getManager();
        $userRepository=$em->getRepository(User::class);
        //requete de selection
        $us=$userRepository->find($id);
        //suppression de l'entity
        $em->remove($us);
        $em->flush();
        $resultat=["ok"];
        $reponse=new JsonResponse($resultat);
        return $reponse;
    }
}
