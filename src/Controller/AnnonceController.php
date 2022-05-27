<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;

use App\Form\FormModifType;

use App\Form\FormAnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/listeEmplois", name="listeEmplois")
     */
    public function listeEmplois(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findBy(array('typeContrat' => array( "CDI","CIVP","CDD","Karama")));
        return $this->render('annonce/listeEmplois.html.twig',["annonces"=>$annonces]);
    }



     /**
     * @Route("/listeStages", name="listeStages")
     */
    public function listeStages(AnnonceRepository $annonceRepository): Response
    {
        $stages = $annonceRepository-> findBy(array('typeContrat' => 'Stage'));

        return $this->render('annonce/listeStages.html.twig',["stages"=>$stages]);
    }



/**
    
     * @Route("/createAnnonce", name="createAnnonce")
     */
    public function createAnnonce(Request $request, EntityManagerInterface $manager,AnnonceRepository $repo)
    {

        $annonce = new Annonce(); 
        $formAnnonce = $this->createForm(FormAnnonceType::class,$annonce);
        
        $formAnnonce->handleRequest($request);



        if($formAnnonce->isSubmitted() and $formAnnonce->isValid()){
            $annonce->setDateAjout(new \DateTime());
            $annonce->setUser($this->getUser());
            $manager->persist($annonce); 
            $manager->flush();
            $this->addFlash("_message","Votre annonce a bien été publiée");
            return $this->redirectToRoute("createAnnonce");
        }



       return $this->render("annonce/create.html.twig",["formAnnonce"=>$formAnnonce->createView() , "labelSubmit"=>"Ajouter l'annonce"]);
    }




    /**
     * 
     * @Route("/{slug<[a-z\-0-9]+>}/{id<[0-9]+>}", name="detailAnnonce")
     */
    public function show(?Annonce $annonce ): Response{
        if($annonce == null){
            throw $this->createNotFoundException("L'annonces demandée n'existe pas !");
        }
       
        return $this->render("annonce/detailAnnonce.html.twig", [
            "annonce"=> $annonce
         
        ]);
    }



    /**
 * @Route("/deleteAnnonce/{id}", name="deleteAnnonce")
 */
public function delete(Request $request, EntityManagerInterface $manager,  int $id): Response
{
 
    $annonce = $manager->find(Annonce::class, $id);

    $manager->remove($annonce);
    $manager->flush();

    return $this->redirectToRoute("profil");
}
    


/**
 * @Route("/modifAnnonce/{id}", name="modifAnnonce")
 */
public function modifAnnonce(?Annonce $annonce,Request $request, EntityManagerInterface $manager): Response
{
    if($annonce ==null)
    $annonce=new Annonce();



  //  $user = $manager->find(User::class, $id);


    $formAnnonce = $this->createForm(FormAnnonceType::class, $annonce);
    $formAnnonce->handleRequest($request);
    if($formAnnonce->isSubmitted() and $formAnnonce->isValid()){
       
        $manager->persist($annonce);
        $manager->flush();
        return $this->redirectToRoute("profil");
    }
    return $this->render("annonce/create.html.twig", [
        "formAnnonce"=> $formAnnonce->createView(), "labelSubmit"=>"Modifier"
    
    ]);
}






}
