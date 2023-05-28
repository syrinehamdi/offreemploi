<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * 
     * @ORM\Column(type="string", length=255)
     *
     * 
     */
    private $poste;



    
/**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Saisir le nom de l'entreprise")
     */
    private $entreprise;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Saisir la description du poste")
     * @Assert\Length(min=15,minMessage="Saisir minimum 20 caractéres")
     */
    private $description;

    /**
     * @Assert\NotBlank(message="Saisir l'adresse de l'entreprise")
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    
    /**
     * @Assert\NotBlank(message="Choisissez le type de contrat")
     * @ORM\Column(type="string", length=255)
     */
    private $typeContrat;

    /**
     * @Assert\NotBlank(message="Saisir le salaire ")
     * @ORM\Column(type="integer")
     */
    private $salaire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAjout;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="annonce")
     */
    private $contacts;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="annonce")
     */
    private $annonce;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->annonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }


    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

  

    public function getTypeContrat(): ?string
    {
        return $this->typeContrat;
    }

    public function setTypeContrat(string $typeContrat): self
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(int $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }


    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

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
            $contact->setAnnonce($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getAnnonce() === $this) {
                $contact->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getAnnonce(): Collection
    {
        return $this->annonce;
    }

    public function addAnnonce(Contact $annonce): self
    {
        if (!$this->annonce->contains($annonce)) {
            $this->annonce[] = $annonce;
            $annonce->setAnnonce($this);
        }

        return $this;
    }

    public function removeAnnonce(Contact $annonce): self
    {
        if ($this->annonce->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getAnnonce() === $this) {
                $annonce->setAnnonce(null);
            }
        }

        return $this;
    }
}
