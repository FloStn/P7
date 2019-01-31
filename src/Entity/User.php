<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields="username", 
 *     message="Le nom d'utilisateur renseigné est indisponible.", 
 * )
 * @UniqueEntity(
 *     fields="email", 
 *     message="L'email renseigné est indisponible.", 
 * )
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *         "user_list",
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
 *     "details",
 *     href = @Hateoas\Route(
 *         "user_details",
 *         parameters = { "id" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

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
