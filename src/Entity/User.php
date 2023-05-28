<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email", message="Adresse email existe déjà")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    

/**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Saisir l'adresse email")
     * @Assert\Email(message = "L'adresse email est incorrect")
     * 
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Saisir le mot de passe")
     * @Assert\Length(min=6,minMessage="Saisir minimum 6 caractéres")

     */
    private $password;

    /**
     * 
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Saisir votre nom")
     */
    private $nom;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Saisir votre prénom")
     */
    private $prenom;

     /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Choisissez le type")
     */
    private $type;

    /**
     * 
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Saisir le numéro de téléphone")
     * @Assert\Length(min=8,minMessage="Saisir 8 chiffres", max=8, maxMessage="Saisir 8 chiffres")
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="user")
     */
    private $annonces;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="user")
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="user")
     */
    private $user;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->user = new ArrayCollection();
        if($this->getType()=='Candidat') $this->setRoles(['ROLE_CANDIDAT']);
        else{
            $this->setRoles(['ROLE_RECRUTEUR']);
        }
    }








    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getType(): ?string
    {
        return $this->type;
    }
    
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }




    public function getNom(): ?string
    {
        return $this->nom;
    }
    
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }


    public function getPrenom(): ?string
    {
        return $this->prenom;
    }
    
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }




    public function getTelephone(): ?string
    {
        return $this->telephone;
    }
    
    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }








    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setUser($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getUser() === $this) {
                $annonce->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setUser($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getUser() === $this) {
                $contact->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Contact $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setUser($this);
        }

        return $this;
    }

    public function removeUser(Contact $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getUser() === $this) {
                $user->setUser(null);
            }
        }

        return $this;
    }
}
