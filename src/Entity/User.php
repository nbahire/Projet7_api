<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\Api\UserCreateController;
use App\Repository\UserRepository;
use App\State\UserProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                'groups' => ['user:detail']
            ]
        ),
        new getCollection(
            normalizationContext: [
                'groups' => ['user:list']
            ]
        ),
        new Post(),
        new Delete(
            security: "is_granted('ROLE_USER')"
        )
    ],
    processor: UserProcessor::class
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[groups(['user:list', 'user:detail'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[
        groups(['user:list', 'user:detail']),
        NotBlank(message: 'Ce champs ne peut être vide.'),
        Email(message: 'Le format de l\'email est incorrect')
    ]
    private ?string $email = null;


    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    #[groups(['client:detail', 'user:detail']),]
    private ?Client $client = null;

    #[ORM\Column(length: 255)]
    #[
        groups(['user:list', 'user:detail']),
        length(min: 5, minMessage: 'Veillez rentrer au  moins 5 caractère'),
        NotBlank(message: 'Ce champs ne peut être vide.'),
    ]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[
        groups(['user:list', 'user:detail']),
        length(min: 5, minMessage: 'Veillez rentrer au  moins 5 caractère'),
        NotBlank(message: 'Ce champs ne peut être vide.'),
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
