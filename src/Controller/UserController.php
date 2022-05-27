<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\FormModifType;
use App\Form\FormRegisterType;
use App\Repository\AnnonceRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * Inscription des utilisateurs
     *
     * @param Request $request requête http
     * @param EntityManagerInterface $manager gestionnaire des entités
     * @param UserPasswordHasherInterface $encoder encodeue des mots de passe
     * @return Response
     * @Route("/inscription", name="register")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response{
        $user = new User();
        $registrationForm = $this->createForm(FormRegisterType::class, $user);
        $registrationForm->handleRequest($request);
        if($registrationForm->isSubmitted() and $registrationForm->isValid()){
            $password = $encoder->hashPassword($user, $user->getPassword());


            $user->setPassword($password);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute("login");
        }
        return $this->render("user/register.html.twig", [
            "registrationForm"=> $registrationForm->createView()
        
        ]);
    }





/**
     *
     * @return void
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils){
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();
       
        return $this->render("user/login.html.twig", [
            "error"=> $error,
            "username"=> $username
        ]);
        return $this->redirectToRoute("profil");

    }

     /**
     * @Route("/profil", name="profil")
     */
    public function profil(AnnonceRepository $annonceRepository, ContactRepository $contactRepository): Response
    {
        $annonces = $annonceRepository-> findBy(array('user' => $this->getUser()));
        $contacts = $contactRepository-> findBy(array('user' => $this->getUser()));

        
        return $this->render('user/profil.html.twig',["annonces"=>$annonces, "contacts"=>$contacts]);


    }

/**
     
     
     * 
     * @Route("/logout", name="logout")
     */
    public function logout(){}







/**
 * @Route("/modifierProfil/{id}", name="modifierProfil")
 */
public function ModifierProfil(?User $user,Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
{
    if($user ==null)
    $user=new User();



  //  $user = $manager->find(User::class, $id);


    $Form = $this->createForm(FormModifType::class, $user);
    $Form->handleRequest($request);
    if($Form->isSubmitted() and $Form->isValid()){
        $password = $encoder->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute("profil");
    }
    return $this->render("user/ModifProfil.html.twig", [
        "FormModif"=> $Form->createView()
    
    ]);
}





}








