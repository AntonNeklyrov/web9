<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

#[ApiResource(
    collectionOperations: [
        'get' => ['method' => 'get'],
    ],
    itemOperations: [
        'get' => ['method' => 'get'],
    ],
)]
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $post_label;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $post_img;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private ?\DateTimeInterface $post_data;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $post_trailer;

    #[ORM\Column(type: 'boolean')]
    private ?boolean $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostLabel(): ?string
    {
        return $this->post_label;
    }

    public function setPostLabel(string $post_label): self
    {
        $this->post_label = $post_label;

        return $this;
    }

    public function getPostImg(): ?string
    {
        return $this->post_img;
    }

    public function setPostImg(string $post_img): self
    {
        $this->post_img = $post_img;

        return $this;
    }

    public function getPostData(): ?\DateTimeInterface
    {
        return $this->post_data;
    }

    public function setPostData(\DateTimeInterface $post_data): self
    {
        $this->post_data = $post_data;

        return $this;
    }

    public function getPostTrailer(): ?string
    {
        return $this->post_trailer;
    }

    public function setPostTrailer(string $post_trailer): self
    {
        $this->post_trailer = $post_trailer;

        return $this;
    }

    public function __toString(): string
   {
       return $this->post_label;
   }

    public function getPostStatus(): ?bool
    {
        return $this->status;
    }

    public function setPostStatus(bool $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }


}
