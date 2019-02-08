<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields="username", 
 *     message="Username already exists." 
 * )
 * @UniqueEntity(
 *     fields="email", 
 *     message="Email already exists."
 * )
 * @UniqueEntity(
 *     fields="phone", 
 *     message="Phone already exists."
 * )
 * @Serializer\ExclusionPolicy("ALL")
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *         "user_details",
 *         parameters = { "id" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *     "remove",
 *     href = @Hateoas\Route(
 *         "user_remove",
 *         parameters = { "id" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *     "register",
 *     href = @Hateoas\Route(
 *         "user_register",
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *     "list",
 *     href = @Hateoas\Route(
 *         "user_list",
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *     "client",
 *     embedded = @Hateoas\Embedded("expr(object.getClient())")
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=45)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=14)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    private $salt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function eraseCredentials()
    {

    }
}
