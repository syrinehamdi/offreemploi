<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\AnnonceRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(AnnonceRepository $anRepo, ContactRepository $cont, UserRepository $user): Response
    {
        $annonces = $anRepo-> findAll();
        $contacts = $cont-> findAll();
        $users = $user-> findAll();
        $Recruteur = $user-> findBy(array('type' => 'Recruteur'));
        $candidat = $user-> findBy(array('type' => 'Candidat'));

        return $this->render('accueil/index.html.twig',["annonces"=>$annonces,"contacts"=>$contacts,"candidat"=>$candidat,"Recruteur"=>$Recruteur ]);
    }
}
