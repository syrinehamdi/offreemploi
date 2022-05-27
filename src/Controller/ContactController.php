<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Contact;
use App\Form\FormContactType;
use App\Repository\AnnonceRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
  






      /**
     * @Route("/createContact/{id}", name="createContact")
     */
    public function createAnnonce(Request $request, EntityManagerInterface $manager,  $id, AnnonceRepository $repo)
    {

        $contact = new Contact(); 
        $formContact = $this->createForm(FormContactType::class,$contact);
        
        $formContact->handleRequest($request);

        if($formContact->isSubmitted() and $formContact->isValid()){

            $user= $this->getUser();

            $annonce = $manager->find(Annonce::class, $id);
            $contact->setAnnonce($annonce);

            $contact->setUser($this->getUser());

            $contact->setDateAjout(new \DateTime());

            $manager->persist($contact); 
           $manager->flush();
            $this->addFlash("_message","Votre contact a bien été envoyée avec succée");
            return $this->redirectToRoute("profil");
        }


       return $this->render("contact/createContact.html.twig",["formContact"=>$formContact->createView()]);
    }



/**
     * @Route("/listeContactRec", name="listeContactRec")
     */
    public function listeContact(ContactRepository $contactRepo, AnnonceRepository $annonceRepo): Response
    {


        $user = $this->getUser();
        $annonce = $annonceRepo-> findBy(array('user' => $user));


        $contacts = $contactRepo-> findBy(array('annonce' => $annonce));
 


        
        return $this->render('contact/listeContact.html.twig', ["contacts"=> $contacts]);
        
    }



/**
 * @Route("/deleteContact/{id}", name="deleteContact")
 */
public function delete(Request $request, EntityManagerInterface $manager,  int $id): Response
{
 
    $contact = $manager->find(Contact::class, $id);

    $manager->remove($contact);
    $manager->flush();

    return $this->redirectToRoute("profil");
}


}



