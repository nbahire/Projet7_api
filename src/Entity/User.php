<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                'groups' => ['read:user']
            ]
        ),
        new getCollection(),
        new Post(
            validationContext: [
                'groups' => ['create:user']
            ]
        ),
        new Delete()
    ],
    normalizationContext: [
        'groups' => ['read:user']
    ],
    order: ['id:ASC']
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[groups(['read:user'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[groups(['read:user'])]
    private ?string $email = null;


    #[ORM\ManyToOne(targetEntity: Client::class,inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\Column(length: 255)]
    #[
        groups(['read:user', 'create:user']),
        length(min: 5, minMessage: 'Veillez rentrer au  moins 5 caractère', groups: ['create:user'])
    ]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[
        groups(['read:user', 'create:user']),
        length(min: 5, minMessage: 'Veillez rentrer au  moins 5 caractère', groups: ['create:user'])
    ]

    private ?string $lastName = null;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

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
}
