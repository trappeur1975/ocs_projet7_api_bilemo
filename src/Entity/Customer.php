<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"group1", "group2"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups({"group1", "group2"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups({"group1", "group2"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"group2"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     * @Groups({"group1", "group2"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"group1", "group2"})
     */
    private $adress;

    /**
     * @ORM\ManyToOne(targetEntity=Compagny::class, inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"group2"})
     */
    private $compagny;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCompagny(): ?Compagny
    {
        return $this->compagny;
    }

    public function setCompagny(?Compagny $compagny): self
    {
        $this->compagny = $compagny;

        return $this;
    }
}
