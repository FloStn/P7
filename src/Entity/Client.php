<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=45)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=45)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=5)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=45)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $phoneNumber;

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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
